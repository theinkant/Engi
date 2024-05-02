<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Resolvers;

use Inkant\Engi\Assembler;
use Inkant\Engi\Contracts\EscapeIdentifierInterface;
use Inkant\Engi\Resolvers\KeyValueResolver;
use Inkant\Engi\Resolvers\NumericResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class KeyValueResolverTest extends TestCase
{
    protected static KeyValueResolver $resolver;
    protected static Assembler $assembler;
    protected static EscapeIdentifierInterface $escaper;

    public static function setUpBeforeClass(): void
    {
        static::$resolver   = new KeyValueResolver(
            new NumericResolver()
        );
        static::$assembler  = new Assembler();
        static::$escaper    = new class () implements EscapeIdentifierInterface {
            public function escapeIdentifier(string $string): string
            {
                return "\"$string\"";
            }
        };
    }

    public static function positives(): array
    {
        return [
            [['column1' => 1, 'column2' => 2] , '"column1"=1,"column2"=2'],
        ];
    }

    #[DataProvider('positives')]
    public function testPositive(
        mixed $value,
        string $result
    ) {
        $this->assertSame(
            $result,
            static::$assembler->assemble(
                static::$resolver->resolve($value)->compile(),
                static::$escaper
            )
        );
    }
}
