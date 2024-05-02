<?php

declare(strict_types=1);

namespace Inkant\Engi\Escapers;

use Inkant\Engi\Contracts\EscapeBinaryInterface;
use Inkant\Engi\Contracts\EscapeIdentifierInterface;
use Inkant\Engi\Contracts\EscapeStringInterface;

interface BasicEscaperInterface extends EscapeIdentifierInterface, EscapeStringInterface, EscapeBinaryInterface
{
}
