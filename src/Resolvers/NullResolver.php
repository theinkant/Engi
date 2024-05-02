<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Tokens\KeywordsEnum;

class NullResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?KeywordsEnum
    {
        return $value === null
            ? KeywordsEnum::NULL
            : null;
    }
}
