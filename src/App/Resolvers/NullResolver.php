<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\App\Tokens\KeywordsEnum;

class NullResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return $value === null
            ? KeywordsEnum::NULL
            : null;
    }
}
