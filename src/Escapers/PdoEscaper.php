<?php

declare(strict_types=1);

namespace Inkant\Engi\Escapers;

class PdoEscaper implements BasicEscaperInterface
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
