<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface EscapeStringInterface
{
    public function escapeString(string $string): string;
}
