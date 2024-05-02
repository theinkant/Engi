<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Tokens\RawToken;

class EscapeResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?RawToken
    {
        return is_string($value)
            ? new RawToken(substr($value, 0, strlen($value) / 2))
            : null;
    }
}
