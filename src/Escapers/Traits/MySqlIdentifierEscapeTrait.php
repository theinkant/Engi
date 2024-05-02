<?php

declare(strict_types=1);

namespace Inkant\Engi\Escapers\Traits;

trait MySqlIdentifierEscapeTrait
{
    public function escapeIdentifier(string $value): string
    {
        return '`' . str_replace('`', '``', $value) . '`';
    }
}
