<?php

declare(strict_types=1);

namespace Inkant\Engi\Resolvers;

use Inkant\Engi\Ast\CommaList;

class ListResolver extends Resolver
{
    public function resolve(mixed $value): ?CommaList
    {
        if (!is_array($value) || !array_is_list($value)) {
            return null;
        }
        $items = [];
        foreach ($value as $v) {
            $items[] = parent::resolve($v);
        }
        return new CommaList(...$items);
    }
}
