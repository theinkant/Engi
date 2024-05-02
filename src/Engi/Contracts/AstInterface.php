<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface AstInterface
{
    public function compile(mixed ...$dependencies): TokensInterface|string;
}
