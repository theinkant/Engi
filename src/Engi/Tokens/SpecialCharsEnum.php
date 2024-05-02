<?php

declare(strict_types=1);

namespace Engi\Tokens;

use Engi\Contracts\TokenInterface;

enum SpecialCharsEnum: string implements TokenInterface
{
    case COMMA = ',';

    case PARENTHESIS_OPEN = '(';
    case PARENTHESIS_CLOSE = ')';
    case BRACKET_OPEN = '[';
    case BRACKET_CLOSE = ']';
    case DOLLAR = '$';
    case QUESTION_MARK = '?';
    case PERIOD = '.';


    public function compile(mixed ...$dependencies): string
    {
        return $this->value;
    }
}
