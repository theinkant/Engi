<?php

declare(strict_types=1);

namespace Engi\App\Ast;

use Engi\Contracts\AstInterface;

class ListBranch extends Node
{
    public function __construct(
        protected AstInterface $delimiter,
        AstInterface ...$items
    ) {
        if (empty($items)) {
            parent::__construct();
            return;
        }
        $result = [array_shift($items)];
        foreach ($items as $v) {
            array_push(
                $result,
                $this->delimiter,
                $v
            );
        }
        parent::__construct(...$result);
    }
}
