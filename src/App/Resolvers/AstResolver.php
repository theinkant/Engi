<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\Contracts\AstInterface;

class AstResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?AstInterface
    {
        return $value instanceof AstInterface
            ? $value
            : null;
    }
}
