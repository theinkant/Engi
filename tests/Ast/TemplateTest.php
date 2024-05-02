<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Ast;

use Inkant\Engi\Assembler;
use Inkant\Engi\Ast\Template;
use Inkant\Engi\Contracts\EscapeIdentifierInterface;
use Inkant\Engi\Contracts\EscapeStringInterface;
use Inkant\Engi\Exceptions\EmptyPlaceholderException;
use Inkant\Engi\Exceptions\ReplacePlaceholderException;
use Inkant\Engi\Parsers\EscapePlaceholderParser;
use Inkant\Engi\Parsers\PrefixPlaceholderParser;
use Inkant\Engi\Placeholders\NamedPlaceholderFactory;
use Inkant\Engi\Placeholders\PlaceholderFactory;
use Inkant\Engi\Placeholders\Sequence;
use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Resolvers\AstResolver;
use Inkant\Engi\Resolvers\BoolResolver;
use Inkant\Engi\Resolvers\EscapeResolver;
use Inkant\Engi\Resolvers\IdentifierResolver;
use Inkant\Engi\Resolvers\KeyValueResolver;
use Inkant\Engi\Resolvers\ListResolver;
use Inkant\Engi\Resolvers\NullResolver;
use Inkant\Engi\Resolvers\NumericResolver;
use Inkant\Engi\Resolvers\Resolver;
use Inkant\Engi\Resolvers\StringResolver;
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
            ['user_id','users'],
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
            $parameters,
            new EscapePlaceholderParser($escaper, $valuePrefix, $identifierPrefix),
            new PrefixPlaceholderParser($values, $valuePrefix),
            new PrefixPlaceholderParser($identifiers, $identifierPrefix),
        );
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
            $parameters,
            new PrefixPlaceholderParser($values, '?'),
        );
        $tokens = $t->compile(...static::$dependencies);
        static::$assembler->assemble($tokens, ...static::$dependencies);
    }
}
