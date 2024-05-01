<?php

declare(strict_types=1);

namespace Engi\App\Parsers;

use Engi\App\Exceptions\PlaceholderParserException;
use Engi\App\Placeholders\Placeholder;
use Engi\Contracts\ParserInterface;

abstract class ParserAbstract implements ParserInterface
{
    abstract protected function factory(string $substr): Placeholder;

    public function matched(string $string): bool
    {
        $pattern = '~^' . $this->pattern() . '$~i';
        return preg_match($pattern, $string) === 1;
    }

    public function parse(string $placeholder): Placeholder
    {
        return $this->matched($placeholder)
            ? $this->factory($placeholder)
            : throw new PlaceholderParserException($placeholder, '~^' . $this->pattern() . '$~i');
    }
}
