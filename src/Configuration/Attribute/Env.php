<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_PROPERTY)]
class Env
{
    private string $value;

    public function __construct(private readonly string $parameter)
    {
        $this->value = getenv($this->parameter);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
