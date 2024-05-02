<?php

declare(strict_types=1);

namespace Inkant\Engi\Ast;

use Inkant\Engi\Contracts\AstInterface;

class Node extends NodeAbstract
{
    /**
     * @var AstInterface[]
     */
    protected array $items;

    public function __construct(
        AstInterface ...$items
    ) {
        $this->items = $items;
    }

    /**
     * @param mixed ...$dependencies
     * @return AstInterface[]|AstInterface
     */
    public function components(mixed ...$dependencies): array|AstInterface
    {
        return $this->items;
    }
}
