<?php

declare(strict_types=1);

namespace Tests\Ast;

use Engi\App\Assembler;
use Engi\App\Ast\Template;
use Engi\App\Exceptions\EmptyPlaceholderException;
use Engi\App\Exceptions\ReplacePlaceholderException;
use Engi\App\Parsers\EscapePlaceholderParser;
use Engi\App\Parsers\PrefixPlaceholderParser;
use Engi\App\Placeholders\NamedPlaceholderFactory;
use Engi\App\Placeholders\PlaceholderFactory;
use Engi\App\Placeholders\Sequence;
use Engi\App\ResolverAbstract;
use Engi\App\Resolvers\AstResolver;
use Engi\App\Resolvers\BoolResolver;
use Engi\App\Resolvers\EscapeResolver;
use Engi\App\Resolvers\IdentifierResolver;
use Engi\App\Resolvers\KeyValueResolver;
use Engi\App\Resolvers\ListResolver;
use Engi\App\Resolvers\NullResolver;
use Engi\App\Resolvers\NumericResolver;
use Engi\App\Resolvers\Resolver;
use Engi\App\Resolvers\StringResolver;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    protected static array $dependencies;
    protected static Assembler $assembler;

    protected static ResolverAbstract $valueResolver;
    protected static ResolverAbstract $identifierResolver;

    public static function setUpBeforeClass(): void
    {
        $resolver = new Resolver(
            new NullResolver(),
            new NumericResolver(),
            new BoolResolver(),
            new AstResolver(),
            new StringResolver()
        );

        static::$valueResolver = new Resolver(
            $resolver,
            new ListResolver($resolver),
            new KeyValueResolver($resolver)
        );

        static::$identifierResolver = new IdentifierResolver();

        static::$assembler = new Assembler();

        $escapeIdentifier = new class () implements EscapeIdentifierInterface {
            public function escapeIdentifier(string $string): string
            {
                return '"' . str_replace('"', '""', $string) . '"';
            }
        };

        $escapeString = new class () implements EscapeStringInterface {
            public function escapeString(string $string): string
            {
                return "'" . str_replace("'", "''", $string) . "'";
            }
        };

        static::$dependencies = [
            $escapeString,
            $escapeIdentifier
        ];
    }

    public static function dataset(): iterable
    {
        yield 'Basic test' => [
            '?','#',
            'SELECT #, ?login, #login, ?, IN(?), #dotted, #dotted_array',
            [
                'some_column',
                'login' => 'mylogin',
                'somevalue',
                [1,2,3],
                'dotted' => 'table.column',
                'dotted_array' => ['table.column','table1.column1']
            ],
            'SELECT "some_column", \'mylogin\', "mylogin", \'somevalue\', IN(1,2,3), "table"."column", "table"."column","table1"."column1"'
        ];

        yield 'Update' => [
            '?','#',
            'UPDATE # SET ?',
            [
                'some_table',
                [
                    'login'     => 'mylogin',
                    'password'  => 'mypassword'
                ],
            ],
            'UPDATE "some_table" SET "login"=\'mylogin\',"password"=\'mypassword\''
        ];

        yield "Escape if prefix intersects with syntax" => [
            ':','@',
            'SELECT @@var2 ::= 2, @, :login, @login, :',
            [
                'some_column',
                'login' => 'mylogin',
                'somevalue'
            ],
            'SELECT @var2 := 2, "some_column", \'mylogin\', "mylogin", \'somevalue\''
        ];

        $t = new Template(
            'SELECT # FROM #',
            new PrefixPlaceholderParser(
                new NamedPlaceholderFactory(
                    new Sequence(),
                    new Resolver(
                        new IdentifierResolver()
                    )
                ),
                '#'
            ),
        );
        $t->apply(['user_id','users']);

        yield "Embedding subquery" => [
            '?','#',
            'SELECT # FROM # WHERE EXISTS(?)',
            [
                'order_id', 'orders',
                $t
            ],
            'SELECT "order_id" FROM "orders" WHERE EXISTS(SELECT "user_id" FROM "users")',
        ];


    }

    #[DataProvider('dataset')]
    public function testFullQuery(
        string $valuePrefix,
        string $identifierPrefix,
        string $query,
        array  $parameters,
        string $result
    ): void {
        $sequence    = new Sequence();
        $identifiers = new NamedPlaceholderFactory($sequence, static::$identifierResolver);
        $values      = new NamedPlaceholderFactory($sequence, static::$valueResolver);
        $escaper     = new PlaceholderFactory(new EscapeResolver());

        $t = new Template(
            $query,
            new EscapePlaceholderParser($escaper, $valuePrefix, $identifierPrefix),
            new PrefixPlaceholderParser($values, $valuePrefix),
            new PrefixPlaceholderParser($identifiers, $identifierPrefix),
        );
        $t->apply($parameters);
        $tokens = $t->compile(...static::$dependencies);
        $this->assertSame(
            $result,
            static::$assembler->assemble($tokens, ...static::$dependencies)
        );
    }

    public static function exceptions(): array
    {
        return [
            'Placeholder not replaced'
                => [[],                EmptyPlaceholderException::class  ],
            'Try replace placeholder with bad value'
                => [[new \stdClass()], ReplacePlaceholderException::class]
        ];
    }

    #[DataProvider('exceptions')]
    public function testExceptions(
        array $parameters,
        string $exception
    ) {
        $this->expectException($exception);
        $sql = 'SELECT ?';
        $sequence    = new Sequence();
        $values      = new NamedPlaceholderFactory($sequence, static::$valueResolver);

        $t = new Template(
            $sql,
            new PrefixPlaceholderParser($values, '?'),
        );
        $t->apply($parameters);
        $tokens = $t->compile(...static::$dependencies);
        static::$assembler->assemble($tokens, ...static::$dependencies);
    }
}
