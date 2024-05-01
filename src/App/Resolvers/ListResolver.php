<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\Ast\CommaList;

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
