<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Assembler;
use Engi\Contracts\EscapeStringInterface;
use Engi\Resolvers\ToStringResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ToStringResolverTest extends TestCase
{
    protected static ToStringResolver $resolver;

    protected static Assembler $assembler;
    protected static EscapeStringInterface $escaper;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver   = new ToStringResolver();
        static::$escaper = new class () implements EscapeStringInterface {
            public function escapeString(string $string): string
            {
                return "!$string!";
            }
        };
    }

    public static function positives(): array
    {
        $object = new class () implements \Stringable {
            public function __toString(): string
            {
                return 'string';
            }
        };

        return [
            "value Stringable"    => [$object],
        ];
    }

    #[DataProvider('positives')]
    public function testPositive(
        mixed $value
    ) {
        $this->assertSame(
            static::$escaper->escapeString(
                (string) $value
            ),
            static::$assembler->assemble(
                static::$resolver->resolve($value),
                static::$escaper
            )
        );
    }
}
