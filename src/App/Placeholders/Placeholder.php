<?php

declare(strict_types=1);

namespace Engi\App\Placeholders;

use Engi\App\Ast\NodeAbstract;
use Engi\App\Exceptions\EmptyPlaceholderException;
use Engi\App\Exceptions\NotResolvedValueException;
use Engi\App\ResolverAbstract;
use Engi\Contracts\AstInterface;
use Engi\Contracts\PlaceholderInterface;

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
