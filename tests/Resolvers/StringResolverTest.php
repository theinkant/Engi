<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Resolvers;

use Inkant\Engi\Assembler;
use Inkant\Engi\Contracts\EscapeStringInterface;
use Inkant\Engi\Resolvers\StringResolver;
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
