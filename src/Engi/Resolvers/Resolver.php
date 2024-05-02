<?php

declare(strict_types=1);

namespace Engi\Resolvers;

use Engi\Contracts\AstInterface;
use Engi\ResolverAbstract;

class Resolver extends ResolverAbstract
{
    /**
     * @var ResolverAbstract[]
     */
    protected array $resolvers;

    public function __construct(
        ResolverAbstract ...$resolvers
    ) {
        $this->resolvers = $resolvers;
    }

    public function resolve(mixed $value): ?AstInterface
    {
        foreach ($this->resolvers as $resolver) {
            $resolved = $resolver->resolve($value);
            if ($resolved !== null) {
                return $resolved;
            }
        }
        return null;
    }
}
