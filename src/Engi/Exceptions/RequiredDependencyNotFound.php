<?php

declare(strict_types=1);

namespace Engi\Exceptions;

class RequiredDependencyNotFound extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct("$class dependency not found in arguments list during compile");
    }
}
