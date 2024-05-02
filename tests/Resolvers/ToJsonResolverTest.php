<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Assembler;
use Engi\Contracts\EscapeStringInterface;
use Engi\Resolvers\ToJsonResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ToJsonResolverTest extends TestCase
{
    protected static ToJsonResolver $resolver;

    protected static Assembler $assembler;
    protected static EscapeStringInterface $escaper;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver   = new ToJsonResolver();
        static::$escaper = new class () implements EscapeStringInterface {
            public function escapeString(string $string): string
            {
                return $string;
            }
        };
    }

    public static function positives(): array
    {
        return [
            "value 'string'"    => ['string'],
            "value array"       => [[]],

            "value bool"        => [true],

            "value -2.38"       => [-2.38],

            "value 1"           => [1],
            "value '1'"         => ['1'],

            "value 0"           => [0],
            "value '0'"         => ['0'],
        ];
    }

    #[DataProvider('positives')]
    public function testPositive(
        mixed $value
    ) {
        $this->assertSame(
            static::$escaper->escapeString(
                json_encode($value)
            ),
            static::$assembler->assemble(
                static::$resolver->resolve($value),
                static::$escaper
            )
        );
    }
}
