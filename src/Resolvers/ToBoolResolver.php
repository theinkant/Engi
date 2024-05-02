<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\Tokens\KeywordsEnum;

class ToBoolResolver extends BoolResolver
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return parent::resolve(
            ($value === 1 || $value === 0 || is_bool($value))
            ? (bool) $value
            : $value
        );
    }
}
