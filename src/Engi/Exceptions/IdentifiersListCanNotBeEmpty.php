<?php

declare(strict_types=1);

namespace Engi\Exceptions;

class IdentifiersListCanNotBeEmpty extends \Exception
{
    public function __construct()
    {
        parent::__construct('List of identifiers values can not be empty');
    }
}
