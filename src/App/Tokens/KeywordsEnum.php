<?php

declare(strict_types=1);

namespace Engi\App\Tokens;

use Engi\Contracts\TokenInterface;

enum KeywordsEnum: string implements TokenInterface
{
    case NULL       = 'NULL';
    case TRUE       = 'TRUE';
    case FALSE      = 'FALSE';
    case SELECT     = 'SELECT';
    case TEXT       = 'TEXT';
    case INTEGER    = 'INTEGER';
    case NUMERIC    = 'NUMERIC';
    case INSERT     = 'INSERT';
    case UPDATE     = 'UPDATE';
    case DELETE     = 'DELETE';
    case FROM       = 'FROM';
    case JOIN       = 'JOIN';
    case LEFT       = 'LEFT';
    case RIGHT      = 'RIGHT';
    case WHERE      = 'WHERE';
    case GROUP      = 'GROUP';
    case BY         = 'BY';
    case HAVING      = 'HAVING';
    case ORDER       = 'ORDER';
    case LIMIT       = 'LIMIT';
    case OFFSET      = 'OFFSET';
    case UNION       = 'UNION';
    case ALL         = 'ALL';
    case WITH        = 'WITH';
    case INNER       = 'INNER';
    case CROSS       = 'CROSS';
    case LATERAL     = 'LATERAL';
    case AS          = 'AS';
    case VALUES      = 'VALUES';
    case AND         = 'AND';
    case OR          = 'OR';
    case IN          = 'IN';
    case ANY         = 'ANY';
    case SOME        = 'SOME';
    case UNNEST      = 'UNNEST';
    case PREPARE      = 'PREPARE';
    case BEGIN         = 'BEGIN';
    case COMMIT         = 'COMMIT';
    case UNKNOWN        = 'UNKNOWN';

    public function compile(mixed ...$dependencies): string
    {
        return $this->value;
    }
}
