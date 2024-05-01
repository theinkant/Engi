<?php

declare(strict_types=1);

namespace Engi\App\Ast;

use Engi\App\AstIterator;
use Engi\App\Tokens;
use Engi\Contracts\AstInterface;
use Engi\Contracts\AstNodeInterface;

abstract class NodeAbstract implements AstNodeInterface
{
    /**
     * @param mixed ...$dependencies
     * @return AstInterface[]|AstInterface
     */
    abstract public function components(mixed ...$dependencies): array|AstInterface;

    final public function compile(mixed ...$dependencies): Tokens
    {
        return new Tokens(new AstIterator([$this], ...$dependencies));
    }
}
