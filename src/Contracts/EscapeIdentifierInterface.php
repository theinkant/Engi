<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface EscapeIdentifierInterface
{
    public function escapeIdentifier(string $string): string;
}
