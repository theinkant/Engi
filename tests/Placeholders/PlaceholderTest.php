<?php

declare(strict_types=1);

namespace Tests\Placeholders;

use Engi\App\Placeholders\Placeholder;
use Engi\App\Resolvers\StringResolver;
use Engi\App\Tokens\StringToken;
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
