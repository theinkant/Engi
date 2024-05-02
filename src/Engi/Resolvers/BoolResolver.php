<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\KeywordsEnum;

class BoolResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return is_bool($value)
            ? ($value ? KeywordsEnum::TRUE : KeywordsEnum::FALSE)
            : null;
    }
}
