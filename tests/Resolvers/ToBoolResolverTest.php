<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Assembler;
use Engi\Resolvers\ToBoolResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ToBoolResolverTest extends TestCase
{
    protected static ToBoolResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver = new ToBoolResolver();
    }

    public static function positives(): array
    {
        return [
            "value 1"           => [1 ,     'TRUE'],
            "value 0"           => [0,      'FALSE'],
            "value true"        => [true ,  'TRUE'],
            "value false"       => [false,  'FALSE'],
        ];
    }

    #[DataProvider('positives')]
    public function testPositive(
        mixed $value,
        mixed $result
    ) {
        $this->assertSame(
            $result,
            static::$assembler->assemble(
                static::$resolver->resolve($value)
            )
        );
    }
}
