<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\KeywordsEnum;

class NullResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return $value === null
            ? KeywordsEnum::NULL
            : null;
    }
}
