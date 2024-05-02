<?php

declare(strict_types=1);

namespace Engi;

use Engi\Ast\Template;
use Engi\Parsers\EscapePlaceholderParser;
use Engi\Parsers\ParserAbstract;
use Engi\Parsers\PrefixPlaceholderParser;
use Engi\Placeholders\NamedPlaceholderFactory;
use Engi\Placeholders\PlaceholderFactory;
use Engi\Placeholders\Sequence;
use Engi\Resolvers\AstResolver;
use Engi\Resolvers\BoolResolver;
use Engi\Resolvers\EscapeResolver;
use Engi\Resolvers\IdentifierResolver;
use Engi\Resolvers\JsonResolver;
use Engi\Resolvers\KeyValueResolver;
use Engi\Resolvers\ListResolver;
use Engi\Resolvers\NullResolver;
use Engi\Resolvers\NumericResolver;
use Engi\Resolvers\Resolver;
use Engi\Resolvers\StringResolver;
use Engi\Resolvers\ToBinaryResolver;
use Engi\Resolvers\ToBoolResolver;
use Engi\Resolvers\ToIntResolver;
use Engi\Resolvers\ToJsonResolver;
use Engi\Resolvers\ToNumericResolver;
use Engi\Resolvers\ToStringResolver;

class Query extends Template
{
    /**
     * @var array<int,ParserAbstract>
     */
    protected array $parsers;
    protected Sequence $sequence;

    public function __construct(
        string $query,
        array $params = [],
    ) {
        $this->sequence = new Sequence();
        $resolvers      = $this->resolvers();
        parent::__construct(
            $query,
            $params,
            ...$this->parsers($resolvers, $this->sequence)
        );
    }

    /**
     * @param array<string,ResolverAbstract> $resolvers pairs $prefix => $resolver
     * @param Sequence $sequence
     * @return ParserAbstract[]
     */
    final protected function parsers(
        array $resolvers,
        Sequence $sequence
    ): array {
        $parsers = [
            new EscapePlaceholderParser(new PlaceholderFactory(new EscapeResolver()), ...array_keys($resolvers))
        ];
        foreach ($resolvers as $prefix => $resolver) {
            $parsers[] = new PrefixPlaceholderParser(
                new NamedPlaceholderFactory($sequence, $resolver),
                $prefix
            );
        }
        return $parsers;
    }

    /**
     * return pairs $prefix => $resolver
     * @return array<string,ResolverAbstract>
     */
    protected function resolvers(): array
    {
        $common = new Resolver(
            new StringResolver(),
            new NumericResolver(),
            new NullResolver(),
            new BoolResolver(),
            new AstResolver(),
            new JsonResolver(),
        );
        return [
            'b?'    => new ToBoolResolver(),
            'j?'    => new ToJsonResolver(),
            'i?'    => new ToIntResolver(),
            'f?'    => new ToNumericResolver(),
            's?'    => new ToStringResolver(),
            'bin?'  => new ToBinaryResolver(),
            '#'     => new IdentifierResolver(),
            '?'     => new Resolver(
                $common,
                new ListResolver($common),
                new KeyValueResolver($common)
            ),
        ];
    }
}
