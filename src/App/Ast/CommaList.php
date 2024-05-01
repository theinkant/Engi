<?php

declare(strict_types=1);

namespace Engi\App\Ast;

use Engi\App\Tokens\SpecialCharsEnum;
use Engi\Contracts\AstInterface;

class CommaList extends ListBranch
{
    public function __construct(
        AstInterface ...$items
    ) {
        parent::__construct(SpecialCharsEnum::COMMA, ...$items);
    }
}
