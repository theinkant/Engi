<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\RawToken;

class EscapeResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?RawToken
    {
        return is_string($value)
            ? new RawToken(substr($value, 0, strlen($value) / 2))
            : null;
    }
}
