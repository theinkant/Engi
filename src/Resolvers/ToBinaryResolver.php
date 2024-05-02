<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Tokens\BinaryToken;

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
