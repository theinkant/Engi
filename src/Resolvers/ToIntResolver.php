<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\Tokens\NumericToken;

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
