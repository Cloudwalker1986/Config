<?php
declare(strict_types=1);

namespace Annotation\ConfigTest\Configuration\Env\Example;

use Annotation\Config\Configuration\Attribute\Env;

class EnvConfig
{
    #[Env('TEST_ONE')]
    private int $valueOne;

    #[Env('TWO')]
    private int $valueTwo;

    #[Env('THREE_FOR_TEST')]
    private int $valueThree;

    #[Env('SOME_TEXT')]
    private string $word;

    #[Env('SINGLE_QUOTES')]
    private string $singleQuotes;

    #[Env('PHP_ARRAY_STYLE')]
    private array $arrayStyle;

    public function getValueOne(): int
    {
        return $this->valueOne;
    }

    public function getValueTwo(): int
    {
        return $this->valueTwo;
    }

    public function getValueThree(): int
    {
        return $this->valueThree;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getSingleQuotes(): string
    {
        return $this->singleQuotes;
    }

    public function getArrayStyle(): array
    {
        return $this->arrayStyle;
    }
}
