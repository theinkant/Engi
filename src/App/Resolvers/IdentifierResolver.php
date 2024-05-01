<?php

declare(strict_types=1);

namespace Engi\App\Resolvers;

use Engi\App\Ast\CommaList;
use Engi\App\Ast\QualifiedName;
use Engi\App\Tokens\SpecialCharsEnum;

class IdentifierResolver extends Resolver
{
    public function resolve(mixed $value): null|CommaList|QualifiedName
    {
        if (is_string($value) && strlen($value)) {
            $path = explode(SpecialCharsEnum::PERIOD->value, $value);
            return new QualifiedName(...$path);
        }

        if (!is_array($value) || !array_is_list($value)) {
            return null;
        }

        $items = [];
        foreach ($value as $item) {
            if (!is_string($item) || !strlen($item)) {
                return null;
            }
            $items[] = $this->resolve($item);
        }

        return new CommaList(...$items);
    }
}
