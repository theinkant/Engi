<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface AssemblerInterface
{
    public function assemble(TokensInterface $tokens, mixed ...$dependencies): string;
}
