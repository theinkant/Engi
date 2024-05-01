<?php

declare(strict_types=1);

namespace Engi\App\Escapers;

use Engi\Contracts\EscapeBinaryInterface;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;

/**
 * @deprecated
 */
class DummyEscaper implements EscapeIdentifierInterface, EscapeStringInterface, EscapeBinaryInterface
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
