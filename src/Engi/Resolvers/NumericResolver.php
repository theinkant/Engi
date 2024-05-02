<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\NumericToken;

class NumericResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?NumericToken
    {
        return (is_float($value) || is_int($value))
            ? new NumericToken($value)
            : null;
    }
}
