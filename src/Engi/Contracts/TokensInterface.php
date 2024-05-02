<?php

declare(strict_types=1);

namespace Engi\Contracts;

/**
 * @extends  \Iterator<int,TokenInterface>
 */
interface TokensInterface extends \Iterator
{
    public function current(): TokenInterface;
}
