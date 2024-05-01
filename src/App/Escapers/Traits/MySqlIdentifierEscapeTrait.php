<?php

declare(strict_types=1);

namespace Engi\App\Escapers\Traits;

trait MySqlIdentifierEscapeTrait
{
    public function escapeIdentifier(string $value): string
    {
        return '`' . str_replace('`', '``', $value) . '`';
    }
}
