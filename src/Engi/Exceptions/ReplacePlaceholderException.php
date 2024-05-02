<?php

declare(strict_types=1);

namespace Engi\Exceptions;

class ReplacePlaceholderException extends \Exception
{
    public function __construct(string $template, int $offset, ?\Throwable $previous)
    {
        $message = "Can't replace placeholder in '$template' at offset $offset'";
        parent::__construct($message, 0, $previous);
    }
}
