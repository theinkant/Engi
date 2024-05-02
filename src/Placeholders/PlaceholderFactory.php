<?php

declare(strict_types=1);

namespace Inkant\Engi\Placeholders;

use Inkant\Engi\ResolverAbstract;

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
