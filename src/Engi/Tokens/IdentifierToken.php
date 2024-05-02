<?php

declare(strict_types=1);

namespace Engi\Tokens;

use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\TokenInterface;
use Engi\Exceptions\RequiredDependencyNotFound;
use Engi\RequiredDependencyTrait;

class IdentifierToken implements TokenInterface
{
    use RequiredDependencyTrait;
    public function __construct(
        protected string $identifier
    ) {
    }

    /**
     * @throws RequiredDependencyNotFound
     */
    public function compile(mixed ...$dependencies): string
    {
        $escaper = $this->required(EscapeIdentifierInterface::class, ...$dependencies);
        return $escaper->escapeIdentifier($this->identifier);
    }
}
