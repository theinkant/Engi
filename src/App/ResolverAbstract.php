<?php

declare(strict_types=1);

namespace Engi\App;

use Engi\Contracts\AstInterface;

abstract class ResolverAbstract
{
    abstract public function resolve(mixed $value): ?AstInterface;
}
