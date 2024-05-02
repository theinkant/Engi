<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\Contracts\AstInterface;
use Engi\ResolverAbstract;

class AstResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?AstInterface
    {
        return $value instanceof AstInterface
            ? $value
            : null;
    }
}
