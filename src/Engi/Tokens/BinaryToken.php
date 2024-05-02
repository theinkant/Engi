<?php

declare(strict_types=1);

namespace Engi\Tokens;

use Engi\Contracts\AstInterface;
use Engi\Contracts\EscapeBinaryInterface;
use Engi\Exceptions\RequiredDependencyNotFound;
use Engi\RequiredDependencyTrait;

class BinaryToken implements AstInterface
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
        $escaper = $this->required(EscapeBinaryInterface::class);
        return $escaper->escapeBinary($this->string);
    }
}
