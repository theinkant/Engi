<?php

declare(strict_types=1);

namespace Inkant\Engi;

use Inkant\Engi\Ast\Template;
use Inkant\Engi\Parsers\EscapePlaceholderParser;
use Inkant\Engi\Parsers\ParserAbstract;
use Inkant\Engi\Parsers\PrefixPlaceholderParser;
use Inkant\Engi\Placeholders\NamedPlaceholderFactory;
use Inkant\Engi\Placeholders\PlaceholderFactory;
use Inkant\Engi\Placeholders\Sequence;
use Inkant\Engi\Resolvers\AstResolver;
use Inkant\Engi\Resolvers\BoolResolver;
use Inkant\Engi\Resolvers\EscapeResolver;
use Inkant\Engi\Resolvers\IdentifierResolver;
use Inkant\Engi\Resolvers\JsonResolver;
use Inkant\Engi\Resolvers\KeyValueResolver;
use Inkant\Engi\Resolvers\ListResolver;
use Inkant\Engi\Resolvers\NullResolver;
use Inkant\Engi\Resolvers\NumericResolver;
use Inkant\Engi\Resolvers\Resolver;
use Inkant\Engi\Resolvers\StringResolver;
use Inkant\Engi\Resolvers\ToBinaryResolver;
use Inkant\Engi\Resolvers\ToBoolResolver;
use Inkant\Engi\Resolvers\ToIntResolver;
use Inkant\Engi\Resolvers\ToJsonResolver;
use Inkant\Engi\Resolvers\ToNumericResolver;
use Inkant\Engi\Resolvers\ToStringResolver;

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
