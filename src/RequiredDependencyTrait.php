<?php

declare(strict_types=1);

namespace Inkant\Engi;

use Inkant\Engi\Exceptions\RequiredDependencyNotFound;

trait RequiredDependencyTrait
{
    /**
     * @param class-string $class
     * @param mixed ...$dependencies
     * @return mixed
     * @throws RequiredDependencyNotFound
     */
    protected function required(string $class, mixed ...$dependencies): mixed
    {
        foreach ($dependencies as $d) {
            if (is_a($d, $class)) {
                return $d;
            }
        }
        throw new RequiredDependencyNotFound($class);
    }
}
