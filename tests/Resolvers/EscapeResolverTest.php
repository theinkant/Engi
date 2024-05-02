<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Assembler;
use Engi\Resolvers\EscapeResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EscapeResolverTest extends TestCase
{
    protected static EscapeResolver $resolver;
    protected static Assembler $assembler;

    public static function setUpBeforeClass(): void
    {
        static::$resolver   = new EscapeResolver();
        static::$assembler  = new Assembler();
    }

    public static function positives(): array
    {
        return [
            "value ?? => ?"     => ['??' ,    '?'],
            "value ## => #"     => ['##',     '#'],
            "value @@ => @"     => ['@@',     '@'],
            "value :: => :"     => ['::',     ':'],
            "value :::: => ::"  => ['::::',   '::'],
            "value @@@@ => @@"  => ['@@@@',   '@@'],
            "value $!$! => $!"  => ['$!$!',   '$!'],
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
