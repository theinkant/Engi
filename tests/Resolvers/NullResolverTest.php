<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Assembler;
use Engi\Resolvers\NullResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NullResolverTest extends TestCase
{
    protected static NullResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$resolver   = new NullResolver();
        static::$assembler  = new Assembler();
    }

    public static function positives(): array
    {
        return [
            "value null"        => [null ,  'NULL'],
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
