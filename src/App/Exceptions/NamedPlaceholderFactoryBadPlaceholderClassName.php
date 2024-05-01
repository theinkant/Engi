<?php

declare(strict_types=1);

namespace Engi\App\Exceptions;

use Exception;
use Engi\App\Placeholders\NamedPlaceholderFactory;
use Engi\App\Placeholders\Placeholder;

class NamedPlaceholderFactoryBadPlaceholderClassName extends Exception
{
    public function __construct(string $class)
    {
        parent::__construct(implode(' ', [
            NamedPlaceholderFactory::class,
            'can create only',
            Placeholder::class,
            'objects, given',
            class_exists($class) ? 'class name' : 'not existing class',
            $class
        ]));
    }
}
