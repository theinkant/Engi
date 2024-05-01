<?php

declare(strict_types=1);

namespace Engi\App\Tokens;

use Engi\Contracts\TokenInterface;

class NumericToken implements TokenInterface
{
    public function __construct(
        protected int|float $value
    ) {
    }

    public function compile(mixed ...$dependencies): string
    {
        return (string) $this->value;
    }
}
