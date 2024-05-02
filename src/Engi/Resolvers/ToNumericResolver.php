<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\Tokens\NumericToken;

class ToNumericResolver extends NumericResolver
{
    public function resolve(mixed $value): ?NumericToken
    {
        return parent::resolve(
            is_numeric($value)
            ? (float) $value
            : $value
        );
    }
}
