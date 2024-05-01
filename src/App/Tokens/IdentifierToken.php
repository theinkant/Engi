<?php

declare(strict_types=1);

namespace Engi\App\Tokens;

use Engi\App\Exceptions\RequiredDependencyNotFound;
use Engi\App\RequiredDependencyTrait;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\TokenInterface;

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
