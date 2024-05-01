<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\Tokens\StringToken;

class ToStringResolver extends StringResolver
{
    public function resolve(mixed $value): ?StringToken
    {
        return parent::resolve(
            ($value instanceof \Stringable)
            ? (string) $value
            : $value
        );
    }
}
