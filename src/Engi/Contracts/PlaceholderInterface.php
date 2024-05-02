<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface PlaceholderInterface extends AstInterface
{
    public function replace(mixed $value): AstInterface;
}
