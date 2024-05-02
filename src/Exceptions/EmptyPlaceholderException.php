<?php

declare(strict_types=1);

namespace Inkant\Engi\Exceptions;

use Inkant\Engi\Placeholders\NamedPlaceholder;
use Inkant\Engi\Placeholders\Placeholder;
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
