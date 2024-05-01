<?php

declare(strict_types=1);

namespace Engi\App\Escapers;

use Engi\Contracts\EscapeBinaryInterface;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;
use PgSql\Connection;

class PostgresqlEscaper implements EscapeIdentifierInterface, EscapeStringInterface, EscapeBinaryInterface
{
    public function __construct(
        protected Connection $connection
    ) {

    }

    public function escapeIdentifier(string $string): string
    {
        return pg_escape_identifier($this->connection, $string);
    }

    public function escapeString(string $string): string
    {
        return pg_escape_string($this->connection, $string);
    }

    public function escapeBinary(string $string): string
    {
        return pg_escape_bytea($this->connection, $string);
    }
}
