<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\Tokens\NumericToken;

class ToIntResolver extends NumericResolver
{
    public function resolve(mixed $value): ?NumericToken
    {
        return parent::resolve(
            !(filter_var($value, FILTER_VALIDATE_INT) === false)
                ? (int) $value
                : $value
        );
    }
}
