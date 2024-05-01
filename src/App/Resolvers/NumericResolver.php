<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\App\Tokens\NumericToken;

class NumericResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?NumericToken
    {
        return (is_float($value) || is_int($value))
            ? new NumericToken($value)
            : null;
    }
}
