<?php

declare(strict_types=1);

namespace Engi;

use Engi\Ast\NodeAbstract;
use Engi\Contracts\AstInterface;

/**
 * @extends  \RecursiveArrayIterator<int,AstInterface>
 */
class AstIterator extends \RecursiveArrayIterator
{
    /**
     * @var array<int,mixed>
     */
    protected array $dependencies;

    /**
     * @param AstInterface|array<int,AstInterface> $array
     * @param mixed ...$dependencies
     */
    public function __construct(AstInterface|array $array = [], mixed ...$dependencies)
    {
        $this->dependencies = $dependencies;
        parent::__construct($array);
    }

    /**
     * @inheritdoc
     */
    public function hasChildren(): bool
    {
        return $this->current() instanceof NodeAbstract;
    }

    /**
     * @inheritdoc
     */
    public function getChildren(): self
    {
        if (!($this->current() instanceof NodeAbstract)) {
            return new self();
        }
        $components = $this->current()->components(...$this->dependencies);
        return new AstIterator(
            is_array($components) ? $components : [$components],
            ...$this->dependencies
        );
    }


    public function current(): AstInterface
    {
        return parent::current();
    }

}
