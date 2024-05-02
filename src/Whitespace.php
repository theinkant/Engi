<?php

declare(strict_types=1);

namespace Inkant\Engi;

class Whitespace implements \Stringable
{
    protected string $result = '';

    public function __toString(): string
    {
        return $this->result === ''
            ? ' '
            : $this->result;
    }

    public function append(self $space): self
    {
        return $this->add((string) $space);
    }

    public function space(int $count = 1): self
    {
        return $this->add(' ', $count);
    }

    public function tab(int $count = 1): self
    {
        return $this->add("\t", $count);
    }

    public function newline(int $count = 1): self
    {
        return $this->add("\n", $count);
    }

    protected function add(string $space, int $count = 1): self
    {
        $this->result .= str_repeat($space, $count);
        return $this;
    }
}
