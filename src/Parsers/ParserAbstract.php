<?php

declare(strict_types=1);

namespace Inkant\Engi\Parsers;

use Inkant\Engi\Contracts\ParserInterface;
use Inkant\Engi\Exceptions\PlaceholderParserException;
use Inkant\Engi\Placeholders\Placeholder;

abstract class ParserAbstract implements ParserInterface
{
    abstract protected function factory(string $substr): Placeholder;

    public function matched(string $string): bool
    {
        $pattern = '~^' . $this->pattern() . '$~i';
        return preg_match($pattern, $string) === 1;
    }

    /**
     * @throws PlaceholderParserException
     */
    public function parse(string $placeholder): Placeholder
    {
        return $this->matched($placeholder)
            ? $this->factory($placeholder)
            : throw new PlaceholderParserException($placeholder, '~^' . $this->pattern() . '$~i');
    }
}
