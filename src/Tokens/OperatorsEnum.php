<?php

declare(strict_types=1);

namespace Inkant\Engi\Tokens;

use Inkant\Engi\Contracts\TokenInterface;

enum OperatorsEnum: string implements TokenInterface
{
    case EQUAL = '=';
    case GREATER = '>';
    case GREATER_OR_EQUAL = '>=';
    case LESS = '<';
    case LESS_OR_EQUAL = '<=';
    case NOT_EQUAL = '!=';
    case DOT = '.';

    public function compile(mixed ...$dependencies): string
    {
        return $this->value;
    }
}
