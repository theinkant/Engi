<?php

declare(strict_types=1);

namespace Engi\Exceptions;

use Engi\Placeholders\NamedPlaceholder;
use Engi\Placeholders\Placeholder;
use Exception;

class EmptyPlaceholderException extends Exception
{
    public function __construct(Placeholder $placeholder)
    {
        $adds = '';
        if ($placeholder instanceof NamedPlaceholder) {
            $key = $placeholder->name();
            $type = is_int($key)
                ? 'index'
                : 'name';
            $adds = ", $type => $key";
        }

        parent::__construct("placeholder was not replaced before compilation$adds");
    }
}
