<?php

declare(strict_types=1);

namespace Engi\Escapers;

/**
 * @deprecated
 */
class DummyEscaper implements BasicEscaperInterface
{
    public function escapeIdentifier(string $string): string
    {
        return $string;
    }

    public function escapeString(string $string): string
    {
        return "'" . str_replace("'", "''", $string) . "'";
    }

    public function escapeBinary(string $string): string
    {
        return $string;
    }
}
