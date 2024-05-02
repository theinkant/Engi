<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\Ast\KeyValue;
use Engi\Contracts\AstInterface;

class KeyValueResolver extends Resolver
{
    public function resolve(mixed $value): ?AstInterface
    {
        if (!is_array($value) || array_is_list($value)) {
            return null;
        }

        $set = [];
        foreach ($value as $k => $v) {
            if (!is_string($k) || !strlen($k)) {
                return null;
            }
            $resolved = parent::resolve($v);
            if ($resolved === null) {
                return null;
            }
            $set[$k] = $resolved;
        }

        return new KeyValue($set);
    }
}
