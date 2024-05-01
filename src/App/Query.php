<?php

declare(strict_types=1);

namespace Engi\App;

use Engi\App\Ast\Template;
use Engi\App\Exceptions\ReplacePlaceholderException;
use Engi\App\Parsers\EscapePlaceholderParser;
use Engi\App\Parsers\ParserAbstract;
use Engi\App\Parsers\PrefixPlaceholderParser;
use Engi\App\Placeholders\NamedPlaceholderFactory;
use Engi\App\Placeholders\PlaceholderFactory;
use Engi\App\Placeholders\Sequence;
use Engi\App\Resolvers\AstResolver;
use Engi\App\Resolvers\BoolResolver;
use Engi\App\Resolvers\EscapeResolver;
use Engi\App\Resolvers\IdentifierResolver;
use Engi\App\Resolvers\JsonResolver;
use Engi\App\Resolvers\KeyValueResolver;
use Engi\App\Resolvers\ListResolver;
use Engi\App\Resolvers\NullResolver;
use Engi\App\Resolvers\NumericResolver;
use Engi\App\Resolvers\Resolver;
use Engi\App\Resolvers\StringResolver;
use Engi\App\Resolvers\ToBinaryResolver;
use Engi\App\Resolvers\ToBoolResolver;
use Engi\App\Resolvers\ToIntResolver;
use Engi\App\Resolvers\ToJsonResolver;
use Engi\App\Resolvers\ToNumericResolver;
use Engi\App\Resolvers\ToStringResolver;
use Engi\Contracts\AssemblerInterface;
use Engi\Contracts\EscapeBinaryInterface;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;

class Query
{
    /**
     * @var array<int,ParserAbstract>
     */
    protected array $parsers;
    protected Sequence $sequence;

    public function __construct(
        protected
        EscapeStringInterface
        &EscapeIdentifierInterface
        &EscapeBinaryInterface
        $escaper
    ) {
        $this->sequence = new Sequence();
        $resolvers      = $this->resolvers();
        $this->parsers  = $this->parsers($resolvers, $this->sequence);
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

    protected function assembler(): AssemblerInterface
    {
        return new Assembler();
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


    /**
     * @param string $query
     * @param array<int|string,mixed> $params
     * @return string
     * @throws ReplacePlaceholderException
     */
    final public function compile(
        string $query,
        array $params = [],
    ): string {
        $this->sequence->reset();
        $ast = new Template(
            $query,
            ...$this->parsers
        );
        $ast->apply($params);
        return $this->assembler()->assemble(
            $ast->compile($this->escaper),
            $this->escaper
        );
    }

}
