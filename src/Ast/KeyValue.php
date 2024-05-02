<?php

declare(strict_types=1);

namespace Inkant\Engi\Ast;

use Inkant\Engi\Contracts\AstInterface;
use Inkant\Engi\Exceptions\KeyValueKeyException;
use Inkant\Engi\Exceptions\KeyValueValueException;
use Inkant\Engi\Tokens\IdentifierToken;
use Inkant\Engi\Tokens\OperatorsEnum;
use Inkant\Engi\Tokens\SpecialCharsEnum;

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
