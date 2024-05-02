<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Assembler;
use Engi\Contracts\EscapeStringInterface;
use Engi\Resolvers\StringResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringResolverTest extends TestCase
{
    protected static StringResolver $resolver;

    protected static Assembler $assembler;
    protected static EscapeStringInterface $escaper;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver   = new StringResolver();
        static::$escaper = new class () implements EscapeStringInterface {
            public function escapeString(string $string): string
            {
                return "!$string!";
            }
        };
    }

    public static function positives(): array
    {
        return [
            "value 'string'"    => ['string'],
        ];
    }

    #[DataProvider('positives')]
    public function testPositive(
        mixed $value
    ) {
        $this->assertSame(
            static::$escaper->escapeString(
                $value
            ),
            static::$assembler->assemble(
                static::$resolver->resolve($value),
                static::$escaper
            )
        );
    }
}
