<?php

declare(strict_types=1);

namespace Engi\App\Ast;

use Engi\App\Exceptions\NotResolvedValueException;
use Engi\App\Exceptions\ReplacePlaceholderException;
use Engi\App\Parsers\ParserAbstract;
use Engi\App\Placeholders\NamedPlaceholder;
use Engi\App\Tokens\RawToken;
use Engi\Contracts\AstInterface;
use SplObjectStorage;

class Template extends NodeAbstract
{
    /**
     * @var SplObjectStorage<AstInterface,int>
     */
    protected SplObjectStorage $placeholders;

    /**
     * @var ParserAbstract[]
     */
    protected array $parsers;
    protected Node $ast;

    public function __construct(
        protected string $template,
        ParserAbstract ...$parsers
    ) {
        $this->placeholders = new SplObjectStorage();
        $this->parsers = $parsers;
        $this->ast = $this->parse($this->template);
    }

    protected function patterns(): string
    {
        $patterns = [];
        foreach ($this->parsers as $replacer) {
            $patterns[] = '(' . $replacer->pattern() . ')';
        }
        return implode('|', $patterns);
    }

    /**
     * @throws \Exception
     */
    public function parse(string $raw): Node
    {
        preg_match_all(
            '~' . $this->patterns() . '~i',
            $raw,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        $components = [];
        $prevOffset = 0;
        foreach ($matches[0] ?? [] as [$substr, $offset]) {
            foreach ($this->parsers as $parser) {
                if (!$parser->matched($substr)) {
                    continue;
                }

                $components[] = new RawToken(substr(
                    $raw,
                    $prevOffset,
                    $offset - $prevOffset
                ));
                $component  = $parser->parse($substr);
                $this->placeholders[$component] = $offset;
                $components[] = $component;
                $prevOffset = $offset + strlen($substr);
            }
        }

        $components[] = new RawToken(substr(
            $raw,
            $prevOffset
        ));

        return new Node(...$components);
    }

    /**
     * @param array<int|string,mixed> $parameters
     * @return void
     * @throws ReplacePlaceholderException
     */
    public function apply(array $parameters): void
    {
        foreach ($this->ast->components() as $node) {
            if (!($node instanceof NamedPlaceholder)) {
                continue;
            }
            $name = $node->name();
            if (array_key_exists($name, $parameters)) {
                try {
                    $node->replace($parameters[$name]);
                } catch (NotResolvedValueException $e) {
                    throw new ReplacePlaceholderException(
                        $this->template,
                        $this->placeholders[$node],
                        $e
                    );
                }
            }
        }
    }

    /**
     * @param mixed ...$dependencies
     * @return Node
     */
    public function components(mixed ...$dependencies): Node
    {
        return $this->ast;
    }
}
