<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface EscapeBinaryInterface
{
    public function escapeBinary(string $string): string;
}
