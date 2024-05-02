<?php

declare(strict_types=1);

namespace Inkant\Engi\Placeholders;

use Inkant\Engi\ResolverAbstract;

class NamedPlaceholderFactory
{
    /**
     * @param Sequence $sequence
     * @param ResolverAbstract $resolver
     */
    public function __construct(
        protected Sequence $sequence,
        protected ResolverAbstract $resolver
    ) {

    }

    protected function name(string $value): int|string
    {
        return $value === ""
            ? $this->sequence->next()
            : $value;
    }

    public function factory(mixed $value): NamedPlaceholder
    {
        return new NamedPlaceholder(
            $this->name($value),
            $this->resolver
        );
    }
}
