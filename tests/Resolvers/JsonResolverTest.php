<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Resolvers;

use Inkant\Engi\Assembler;
use Inkant\Engi\Contracts\EscapeStringInterface;
use Inkant\Engi\Resolvers\JsonResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class JsonResolverTest extends TestCase
{
    protected static JsonResolver $resolver;

    protected static Assembler $assembler;
    protected static EscapeStringInterface $escaper;

    public static function setUpBeforeClass(): void
    {
        static::$assembler  = new Assembler();
        static::$resolver   = new JsonResolver();
        static::$escaper    = new class () implements EscapeStringInterface {
            public function escapeString(string $string): string
            {
                return "!$string!";
            }
        };
    }

    public static function positives(): array
    {
        $object = new class () implements \JsonSerializable {
            public function jsonSerialize(): array
            {
                return [1,2];
            }
        };

        return [
            "value JsonSerializable"    => [$object],
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
