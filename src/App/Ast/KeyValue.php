<?php

declare(strict_types=1);

namespace Engi\App\Ast;

use Engi\App\Exceptions\KeyValueKeyException;
use Engi\App\Exceptions\KeyValueValueException;
use Engi\App\Tokens\IdentifierToken;
use Engi\App\Tokens\OperatorsEnum;
use Engi\App\Tokens\SpecialCharsEnum;
use Engi\Contracts\AstInterface;

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
