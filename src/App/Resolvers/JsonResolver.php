<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\ResolverAbstract;
use Engi\App\Tokens\StringToken;

class JsonResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return $value instanceof \JsonSerializable
            ? new StringToken(json_encode($value->jsonSerialize()))
            : null;
    }
}
