<?php

declare(strict_types=1);

namespace Engi\Ast;

use Engi\Tokens\IdentifierToken;
use Engi\Tokens\SpecialCharsEnum;

class QualifiedName extends ListBranch
{
    public function __construct(
        QualifiedName|IdentifierToken|string ...$parts
    ) {
        $items = [];
        foreach ($parts as $part) {
            if (is_string($part)) {
                $part = new IdentifierToken($part);
            }
            $items[] = $part;
        }
        parent::__construct(SpecialCharsEnum::PERIOD, ...$items);
    }
}
