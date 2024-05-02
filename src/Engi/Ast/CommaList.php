<?php

declare(strict_types=1);

namespace Engi\Ast;

use Engi\Contracts\AstInterface;
use Engi\Tokens\SpecialCharsEnum;

class CommaList extends ListBranch
{
    public function __construct(
        AstInterface ...$items
    ) {
        parent::__construct(SpecialCharsEnum::COMMA, ...$items);
    }
}
