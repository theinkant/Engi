<?php

declare(strict_types=1);

namespace Engi\App\Ast;

use Engi\App\Tokens\IdentifierToken;
use Engi\App\Tokens\SpecialCharsEnum;

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
