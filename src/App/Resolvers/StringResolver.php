<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\App\Tokens\StringToken;

class StringResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return is_string($value)
            ? new StringToken($value)
            : null;
    }
}
