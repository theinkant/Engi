<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface PlaceholderInterface extends AstInterface
{
    public function replace(mixed $value): AstInterface;
}
