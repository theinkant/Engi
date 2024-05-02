<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface TokenInterface extends AstInterface
{
    public function compile(mixed ...$dependencies): string;
}
