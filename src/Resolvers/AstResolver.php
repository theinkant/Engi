<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\Contracts\AstInterface;
use Inkant\Engi\ResolverAbstract;

class AstResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?AstInterface
    {
        return $value instanceof AstInterface
            ? $value
            : null;
    }
}
