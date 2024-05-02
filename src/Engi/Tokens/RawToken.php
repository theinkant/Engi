<?php

declare(strict_types=1);

namespace Engi\Tokens;

use Engi\Contracts\TokenInterface;

class RawToken implements TokenInterface
{
    public function __construct(
        protected string $body
    ) {
    }

    public function compile(mixed ...$dependencies): string
    {
        return $this->body;
    }
}
