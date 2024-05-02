<?php

declare(strict_types=1);

namespace Inkant\Engi\Exceptions;

use Inkant\Engi\Contracts\AstInterface;
use Exception;

class KeyValueValueException extends Exception
{
    public function __construct(mixed $value)
    {
        $class = AstInterface::class;
        $type = gettype($value);
        if ($type === 'object') {
            $type .= ' of ' . get_class($value);
        }
        parent::__construct("Key=value syntax handles only $class\[\] values, given $type");
    }
}
