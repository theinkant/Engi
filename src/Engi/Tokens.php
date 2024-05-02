<?php

declare(strict_types=1);

namespace Engi;

use Engi\Contracts\TokenInterface;
use Engi\Contracts\TokensInterface;

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
