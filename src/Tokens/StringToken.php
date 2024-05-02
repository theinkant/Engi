<?php

declare(strict_types=1);

namespace Inkant\Engi\Tokens;

use Inkant\Engi\Contracts\EscapeStringInterface;
use Inkant\Engi\Contracts\TokenInterface;
use Inkant\Engi\Exceptions\RequiredDependencyNotFound;
use Inkant\Engi\RequiredDependencyTrait;

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
