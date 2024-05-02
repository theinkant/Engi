<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\ResolverAbstract;
use Inkant\Engi\Tokens\StringToken;

class JsonResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return $value instanceof \JsonSerializable
            ? new StringToken(json_encode($value->jsonSerialize()))
            : null;
    }
}
