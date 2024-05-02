<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Resolvers;

use Inkant\Engi\Assembler;
use Inkant\Engi\Resolvers\ToNumericResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ToNumericResolverTest extends TestCase
{
    protected static ToNumericResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver   = new ToNumericResolver();
    }
    public static function positives(): array
    {
        return [
            "value 2.38"        => [2.38,       '2.38'],
            "value '-2.38'"     => ['-2.38',    '-2.38'],

            "value 1"           => [1,          '1'],
            "value '1'"         => ['1',        '1'],

            "value 0"           => [0,          '0'],
            "value '0'"         => ['0',        '0'],

            "value 123456"      => [123456,     '123456'],
            "value '123456'"    => ['123456',   '123456'],

            "value -1"          => [-1,         '-1'],
            "value '-1'"        => ['-1',       '-1'],

            "value -123456"     => [-123456,    '-123456'],
            "value '-123456'"   => ['-123456',  '-123456'],
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
