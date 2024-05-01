<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface EscapeStringInterface
{
    public function escapeString(string $string): string;
}
