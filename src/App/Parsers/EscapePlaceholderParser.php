<?php

declare(strict_types=1);

namespace Engi\App\Parsers;

use Engi\App\Placeholders\Placeholder;
use Engi\App\Placeholders\PlaceholderFactory;

class EscapePlaceholderParser extends ParserAbstract
{
    /**
     * @var array<int,string>
     */
    protected array $strings = [];
    public function __construct(
        protected PlaceholderFactory $factory,
        string ...$strings
    ) {
        $this->strings = $strings;
    }

    public function pattern(): string
    {
        $sequences = [];
        foreach ($this->strings as $string) {
            $s = preg_quote($string);
            $sequences[] = '(' . $s . $s  . ')';
        }
        return implode('|', $sequences);
    }

    protected function factory(string $substr): Placeholder
    {
        return $this->factory->factory($substr);
    }
}
