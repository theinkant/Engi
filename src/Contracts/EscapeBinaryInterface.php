<?php

declare(strict_types=1);

namespace Inkant\Engi\Contracts;

interface EscapeBinaryInterface
{
    public function escapeBinary(string $string): string;
}
