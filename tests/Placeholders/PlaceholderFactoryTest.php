<?php

declare(strict_types=1);

namespace Tests\Placeholders;

use Engi\Placeholders\NamedPlaceholderFactory;
use Engi\Placeholders\Sequence;
use Engi\Resolvers\NumericResolver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PlaceholderFactoryTest extends TestCase
{
    protected static \InfiniteIterator $factoryIterator;

    public static function setUpBeforeClass(): void
    {
        $sequence = new Sequence();
        static::$factoryIterator = new \InfiniteIterator(new \ArrayIterator([
            new NamedPlaceholderFactory($sequence, new NumericResolver()),
            new NamedPlaceholderFactory($sequence, new NumericResolver())
        ]));
    }

    public static function providePlaceholderNames(): iterable
    {
        yield 'empty raw 0, sequence::next called'
            => [''     , 0];
        yield 'empty raw 1, sequence::next called'
            => [''     , 1];
        yield 'name1 passed as is'
            => ['name1', 'name1'];
        yield 'empty raw 3, sequence::next called'
            => [''     , 2];
        yield 'name2 name1 passed as is'
            => ['name2', 'name2'];
    }

    #[DataProvider('providePlaceholderNames')]
    public function testCreatedPlaceholdersNamesAndContinuousNumbering(
        string $raw,
        string|int $name
    ) {
        static::$factoryIterator->next();
        $factory = static::$factoryIterator->current();
        $placeholder = $factory->factory($raw);
        $this->assertSame($name, $placeholder->name());
    }
}
