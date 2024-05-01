<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\App\Assembler;
use Engi\App\Resolvers\ToIntResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ToIntResolverTest extends TestCase
{
    protected static ToIntResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver = new ToIntResolver();
    }

    public static function positives(): array
    {
        return [
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
