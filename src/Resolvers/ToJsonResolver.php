<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\Tokens\StringToken;

class ToJsonResolver extends StringResolver
{
    public function __construct(
        protected int $flags = 0,
        protected int $depth = 512
    ) {

    }

    public function resolve(mixed $value): ?StringToken
    {
        return parent::resolve(
            json_encode($value, $this->flags, $this->depth)
        );
    }
}
