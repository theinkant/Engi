<?php

declare(strict_types=1);

namespace Engi\Placeholders;

use Engi\Ast\NodeAbstract;
use Engi\Contracts\AstInterface;
use Engi\Contracts\PlaceholderInterface;
use Engi\Exceptions\EmptyPlaceholderException;
use Engi\Exceptions\NotResolvedValueException;
use Engi\ResolverAbstract;

class Placeholder extends NodeAbstract implements PlaceholderInterface
{
    protected AstInterface $replace;

    public function __construct(
        protected ResolverAbstract $resolver
    ) {

    }

    /**
     * @throws EmptyPlaceholderException
     */
    public function components(mixed ...$dependencies): AstInterface
    {
        return $this->replaced()
            ?: throw new EmptyPlaceholderException($this);
    }

    public function replaced(): ?AstInterface
    {
        return $this->replace ?? null;
    }

    /**
     * @throws NotResolvedValueException
     */
    public function replace(mixed $value): AstInterface
    {
        return $this->replace = $this->resolver->resolve($value)
            ?? throw new NotResolvedValueException($value);
    }
}
