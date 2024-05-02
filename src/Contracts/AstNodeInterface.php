<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface AstNodeInterface extends AstInterface
{
    public function compile(mixed ...$dependencies): TokensInterface;
}
