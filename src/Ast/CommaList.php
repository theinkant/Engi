<?php

declare(strict_types=1);

namespace Inkant\Engi\Ast;

use Inkant\Engi\Contracts\AstInterface;
use Inkant\Engi\Tokens\SpecialCharsEnum;

class CommaList extends ListBranch
{
    public function __construct(
        AstInterface ...$items
    ) {
        parent::__construct(SpecialCharsEnum::COMMA, ...$items);
    }
}
