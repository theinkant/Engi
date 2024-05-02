<?php

declare(strict_types=1);

namespace Engi\Ast;

use Engi\Contracts\AstInterface;
use Engi\Exceptions\KeyValueKeyException;
use Engi\Exceptions\KeyValueValueException;
use Engi\Tokens\IdentifierToken;
use Engi\Tokens\OperatorsEnum;
use Engi\Tokens\SpecialCharsEnum;

class KeyValue extends ListBranch
{
    /**
     * @param array<string,AstInterface> $set
     * @throws KeyValueValueException
     * @throws KeyValueKeyException
     */
    public function __construct(
        protected array $set
    ) {
        $items = [];
        foreach ($set as $key => $value) {
            if (!is_string($key) || !strlen($key)) {
                throw new KeyValueKeyException($key);
            }
            if (!($value instanceof AstInterface)) {
                throw new KeyValueValueException($value);
            }
            $items[] = new ListBranch(
                OperatorsEnum::EQUAL,
                new IdentifierToken($key),
                $value
            );
        }

        parent::__construct(SpecialCharsEnum::COMMA, ...$items);
    }
}
