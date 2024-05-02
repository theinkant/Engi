<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Resolvers;

use Inkant\Engi\Assembler;
use Inkant\Engi\Resolvers\BoolResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BoolResolverTest extends TestCase
{
    protected static BoolResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$resolver   = new BoolResolver();
        static::$assembler  = new Assembler();
    }

    public static function positives(): array
    {
        return [
            "value true"        => [true ,  'TRUE'],
            "value false"       => [false,  'FALSE'],
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
