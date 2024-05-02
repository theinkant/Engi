<?php

declare(strict_types=1);

namespace Engi\Ast;

use Engi\AstIterator;
use Engi\Contracts\AstInterface;
use Engi\Contracts\AstNodeInterface;
use Engi\Tokens;

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
