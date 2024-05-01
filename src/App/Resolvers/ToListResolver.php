<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\Ast\CommaList;

class ToListResolver extends ListResolver
{
    public function resolve(mixed $value): ?CommaList
    {
        return parent::resolve(
            (is_array($value))
                ? array_values($value)
                : $value
        );
    }

}
