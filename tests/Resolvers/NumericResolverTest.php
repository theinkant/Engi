<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Resolvers;

use Inkant\Engi\Assembler;
use Inkant\Engi\Resolvers\NumericResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NumericResolverTest extends TestCase
{
    protected static NumericResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver = new NumericResolver();
    }

    public static function positives(): array
    {
        return [
            "value 2.38"        => [2.38,   "2.38"],
            "value 1"           => [1,      "1"],
            "value 0"           => [0,      "0"],
            "value 123456"      => [123456, "123456"],
            "value -1"          => [-1,     "-1"],
            "value -123456"     => [-123456,"-123456"],
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
                static::$resolver->resolve($value)
            )
        );
    }
}
