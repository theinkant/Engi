<?php

declare(strict_types=1);

namespace Engi\App\Exceptions;

use Exception;

class KeyValueKeyException extends Exception
{
    public function __construct(int|string $index)
    {
        parent::__construct("Key=value syntax handles arrays only with nt empty string keys, given $index");
    }
}
