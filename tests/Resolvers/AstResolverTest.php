<?php

declare(strict_types=1);

namespace Tests\Resolvers;

use Engi\Ast\CommaList;
use Engi\Resolvers\AstResolver;
use Engi\Tokens\RawToken;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AstResolverTest extends TestCase
{
    protected static AstResolver $resolver;

    public static function setUpBeforeClass(): void
    {
        static::$resolver   = new AstResolver();
    }

    public static function positives(): array
    {
        return [
            "value RawToken" => [new RawToken('token')],
            "value CommaList" => [new CommaList(
                new RawToken('token'),
                new RawToken('token')
            )]
        ];
    }

    #[DataProvider('positives')]
    public function testPositive(
        mixed $value
    ) {
        $this->assertSame(
            $value,
            static::$resolver->resolve($value)
        );
    }
}
