<?php

declare(strict_types=1);

namespace Inkant\Engi\Exceptions;

class PlaceholderParserException extends \Exception
{
    public function __construct(string $substr, string $pattern)
    {
        parent::__construct("pattern $pattern not found in \"$substr\"");
    }
}
