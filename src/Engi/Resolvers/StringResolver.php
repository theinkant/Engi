<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\StringToken;

class StringResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return is_string($value)
            ? new StringToken($value)
            : null;
    }
}
