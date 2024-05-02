<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\Ast\CommaList;

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
