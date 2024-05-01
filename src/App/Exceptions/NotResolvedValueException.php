<?php

declare(strict_types=1);

namespace Engi\App\Exceptions;

class NotResolvedValueException extends \Exception
{
    public function __construct(mixed $value)
    {
        $type = gettype($value);
        if ($type === 'object') {
            $type .= ' of ' . get_class($value);
        }

        parent::__construct('Not resolved value for placeholder, given ' . $type);
    }
}
