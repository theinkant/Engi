<?php

declare(strict_types=1);

namespace Engi\App;

use Engi\App\Ast\Template;
use Engi\Contracts\EscapeBinaryInterface;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;

class Compiler
{
    protected Assembler $assembler;
    public function __construct(
        protected
        EscapeBinaryInterface
        &EscapeIdentifierInterface
        &EscapeStringInterface
        $escaper
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
