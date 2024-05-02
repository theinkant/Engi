<?php

declare(strict_types=1);

namespace Engi\Escapers\Traits;

trait SqlIdentifierEscapeTrait
{
    public function escapeIdentifier(string $value): string
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }
}
