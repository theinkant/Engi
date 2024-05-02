<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface EscapeIdentifierInterface
{
    public function escapeIdentifier(string $string): string;
}
