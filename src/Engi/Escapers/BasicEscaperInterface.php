<?php

declare(strict_types=1);

namespace Engi\Escapers;

use Engi\Contracts\EscapeBinaryInterface;
use Engi\Contracts\EscapeIdentifierInterface;
use Engi\Contracts\EscapeStringInterface;

interface BasicEscaperInterface extends EscapeIdentifierInterface, EscapeStringInterface, EscapeBinaryInterface
{
}
