<?php

declare(strict_types=1);

namespace Inkant\Engi\Exceptions;

use Inkant\Engi\Placeholders\NamedPlaceholderFactory;
use Inkant\Engi\Placeholders\Placeholder;
use Exception;

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
