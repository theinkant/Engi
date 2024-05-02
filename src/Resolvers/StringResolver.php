<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Tokens\StringToken;

class StringResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return is_string($value)
            ? new StringToken($value)
            : null;
    }
}
