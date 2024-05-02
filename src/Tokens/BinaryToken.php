<?php

declare(strict_types=1);

namespace Inkant\Engi\Tokens;

use Inkant\Engi\Contracts\AstInterface;
use Inkant\Engi\Contracts\EscapeBinaryInterface;
use Inkant\Engi\Exceptions\RequiredDependencyNotFound;
use Inkant\Engi\RequiredDependencyTrait;

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
