<?php

declare(strict_types=1);

namespace Engi\Parsers;

use Engi\Placeholders\NamedPlaceholder;
use Engi\Placeholders\NamedPlaceholderFactory;

class PrefixPlaceholderParser extends ParserAbstract
{
    public function __construct(
        protected NamedPlaceholderFactory $factory,
        protected string $prefix,
        protected string $name = '[a-zA-Z0-9_]'
    ) {

    }

    public function pattern(): string
    {
        $prefix = preg_quote($this->prefix);
        return $prefix . '(' . $this->name   . '+)?';
    }

    protected function factory(string $substr): NamedPlaceholder
    {
        return $this->factory->factory(
            substr($substr, strlen($this->prefix))
        );
    }
}
