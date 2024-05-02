<?php

declare(strict_types=1);

namespace Inkant\Engi\Tests\Placeholders;

use Inkant\Engi\Placeholders\Placeholder;
use Inkant\Engi\Resolvers\StringResolver;
use Inkant\Engi\Tokens\StringToken;
use PHPUnit\Framework\TestCase;

class PlaceholderTest extends TestCase
{
    protected Placeholder $placeholder;

    protected function setUp(): void
    {
        $this->placeholder = new Placeholder(
            new StringResolver()
        );
    }

    public function testReplace(): void
    {
        $value = 'replaced';
        $this->assertInstanceOf(
            StringToken::class,
            $this->placeholder->replace($value)
        );
    }

}
