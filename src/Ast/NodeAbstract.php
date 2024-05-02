<?php

declare(strict_types=1);

namespace Inkant\Engi\Ast;

use Inkant\Engi\AstIterator;
use Inkant\Engi\Contracts\AstInterface;
use Inkant\Engi\Contracts\AstNodeInterface;
use Inkant\Engi\Tokens;

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
