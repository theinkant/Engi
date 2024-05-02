<?php

declare(strict_types=1);

namespace Engi\Tokens;

use Engi\Contracts\EscapeStringInterface;
use Engi\Contracts\TokenInterface;
use Engi\Exceptions\RequiredDependencyNotFound;
use Engi\RequiredDependencyTrait;

class StringToken implements TokenInterface
{
    use RequiredDependencyTrait;
    public function __construct(
        protected string $string
    ) {
    }

    /**
     * @throws RequiredDependencyNotFound
     */
    public function compile(mixed ...$dependencies): string
    {
        $escaper = $this->required(EscapeStringInterface::class, ...$dependencies);
        return $escaper->escapeString($this->string);
    }
}
