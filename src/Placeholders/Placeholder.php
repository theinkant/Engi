<?php

declare(strict_types=1);

namespace Inkant\Engi\Placeholders;

use Inkant\Engi\Ast\NodeAbstract;
use Inkant\Engi\Contracts\AstInterface;
use Inkant\Engi\Contracts\PlaceholderInterface;
use Inkant\Engi\Exceptions\EmptyPlaceholderException;
use Inkant\Engi\Exceptions\NotResolvedValueException;
use Inkant\Engi\ResolverAbstract;

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
