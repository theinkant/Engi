<?php

declare(strict_types=1);

namespace Inkant\Engi;

use Inkant\Engi\Contracts\AssemblerInterface;
use Inkant\Engi\Contracts\TokenInterface;
use Inkant\Engi\Contracts\TokensInterface;

class Assembler implements AssemblerInterface
{
    public function assemble(TokensInterface|TokenInterface $tokens, mixed ...$dependencies): string
    {
        if ($tokens instanceof TokenInterface) {
            $tokens = [$tokens];
        }
        $result = '';
        foreach ($tokens as $token) {
            $result .= $token->compile(...$dependencies);
        }
        return $result;
    }
}
