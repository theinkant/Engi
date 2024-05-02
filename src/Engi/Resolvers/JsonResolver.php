<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\ResolverAbstract;
use Engi\Tokens\StringToken;

class JsonResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return $value instanceof \JsonSerializable
            ? new StringToken(json_encode($value->jsonSerialize()))
            : null;
    }
}
