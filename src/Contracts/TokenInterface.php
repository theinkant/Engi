<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface TokenInterface extends AstInterface
{
    public function compile(mixed ...$dependencies): string;
}
