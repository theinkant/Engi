<?php

declare(strict_types=1);

namespace Engi\App\Escapers;

use Engi\Contracts\EscapeBinaryInterface;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;

class PdoEscaper implements EscapeIdentifierInterface, EscapeStringInterface, EscapeBinaryInterface
{
    public function __construct(
        protected \PDO $connection
    ) {

    }

    public function escapeIdentifier(string $string): string
    {
        return $string;
    }

    public function escapeString(string $string): string
    {
        return $this->connection->quote($string);
    }

    public function escapeBinary(string $string): string
    {
        return $this->connection->quote($string, \PDO::PARAM_LOB);
    }
}
