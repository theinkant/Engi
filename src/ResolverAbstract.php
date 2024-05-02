<?php

declare(strict_types=1);

namespace Inkant\Engi;

use Inkant\Engi\Contracts\AstInterface;

abstract class ResolverAbstract
{
    abstract public function resolve(mixed $value): ?AstInterface;
}
