<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\BinaryToken;

class ToBinaryResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?BinaryToken
    {
        return
            (is_string($value))
            ? new BinaryToken($value)
            : null;
    }
}
