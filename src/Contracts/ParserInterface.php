<?php

declare(strict_types=1);

namespace Engi\Contracts;

interface ParserInterface
{
    public function pattern(): string;
    public function matched(string $string): bool;
    public function parse(string $placeholder): PlaceholderInterface;
}
