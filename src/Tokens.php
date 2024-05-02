<?php

declare(strict_types=1);

namespace Inkant\Engi;

use Inkant\Engi\Contracts\TokenInterface;
use Inkant\Engi\Contracts\TokensInterface;

class Tokens extends \RecursiveIteratorIterator implements TokensInterface
{
    public function __construct(AstIterator $iterator)
    {
        parent::__construct($iterator);
    }

    public function current(): TokenInterface
    {
        return parent::current();
    }
}
