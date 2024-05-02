<?php

declare(strict_types=1);

namespace Engi\Placeholders;

use Engi\ResolverAbstract;

class PlaceholderFactory
{
    public function __construct(
        protected ResolverAbstract $resolver
    ) {

    }

    public function factory(mixed $value): Placeholder
    {
        $placeholder = new Placeholder(
            $this->resolver
        );
        $placeholder->replace($value);
        return $placeholder;
    }
}
