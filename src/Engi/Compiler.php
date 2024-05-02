<?php

declare(strict_types=1);

namespace Engi;

use Engi\Ast\Template;
use Engi\Escapers\BasicEscaperInterface;

class Compiler
{
    protected Assembler $assembler;
    public function __construct(
        protected BasicEscaperInterface $escaper
    ) {
        $this->assembler = new Assembler();
    }

    public function compile(Template $template): string
    {
        return $this->assembler->assemble(
            $template->compile(),
            $this->escaper
        );
    }
}
