<?php

declare(strict_types=1);

namespace Engi\App\Placeholders;

use Engi\App\ResolverAbstract;

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
