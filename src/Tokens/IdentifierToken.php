<?php

declare(strict_types=1);

namespace Inkant\Engi\Tokens;

use Inkant\Engi\Contracts\EscapeIdentifierInterface;
use Inkant\Engi\Contracts\TokenInterface;
use Inkant\Engi\Exceptions\RequiredDependencyNotFound;
use Inkant\Engi\RequiredDependencyTrait;

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
