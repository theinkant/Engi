<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\App\Tokens\KeywordsEnum;

class BoolResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return is_bool($value)
            ? ($value ? KeywordsEnum::TRUE : KeywordsEnum::FALSE)
            : null;
    }
}
