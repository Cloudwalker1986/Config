<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration\Attribute;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class Value
{
    public function __construct(private readonly string $path){}

    public function getPath(): string
    {
        return $this->path;
    }
}
