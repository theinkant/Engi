<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Tokens\KeywordsEnum;

class BoolResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return is_bool($value)
            ? ($value ? KeywordsEnum::TRUE : KeywordsEnum::FALSE)
            : null;
    }
}
