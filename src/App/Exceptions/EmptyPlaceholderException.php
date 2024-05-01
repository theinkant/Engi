<?php

declare(strict_types=1);

namespace Engi\App\Exceptions;

use Exception;
use Engi\App\Placeholders\NamedPlaceholder;
use Engi\App\Placeholders\Placeholder;

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
