<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\App\Assembler;
use Engi\App\Resolvers\IdentifierResolver;
use Engi\Contracts\EscapeIdentifierInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IdentifiersResolverTest extends TestCase
{
    protected static IdentifierResolver $resolver;
    protected static Assembler $assembler;
    protected static EscapeIdentifierInterface $escaper;

    public static function setUpBeforeClass(): void
    {
        static::$resolver   = new IdentifierResolver();
        static::$assembler  = new Assembler();
        static::$escaper    = new class () implements EscapeIdentifierInterface {
            public function escapeIdentifier(string $string): string
            {
                return "\"$string\"";
            }
        };
    }

    public static function positives(): array
    {
        return [
            "simple name"       => ['column' ,                              '"column"'],
            "dotted name"       => ['table.column' ,                        '"table"."column"'],
            "dotted names list" => [['table1.column1','table2.column2'] ,   '"table1"."column1","table2"."column2"'],
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
                static::$resolver->resolve($value)->compile(),
                static::$escaper
            )
        );
    }
}
