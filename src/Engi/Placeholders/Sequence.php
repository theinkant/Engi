<?php

declare(strict_types=1);

namespace Engi\Placeholders;

class Sequence
{
    protected int $counter = 0;

    public function next(): int
    {
        return $this->counter++;
    }

    public function current(): int
    {
        return $this->counter;
    }

    public function reset(): void
    {
        $this->counter = 0;
    }
}
