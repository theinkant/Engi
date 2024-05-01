<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\App\Tokens\BinaryToken;

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
