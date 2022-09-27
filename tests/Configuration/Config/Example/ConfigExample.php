<?php
declare(strict_types=1);

namespace Annotation\ConfigTest\Configuration\Config\Example;

use Annotation\Config\Configuration\Attribute\Configuration;
use Annotation\Config\Configuration\Attribute\Value;

#[Configuration]
class ConfigExample
{
    #[Value('root.firstLevelString.secondLevelHello')]
    private string $hello;

    #[Value('root.firstLevelString.secondLevelWorld')]
    private string $world;

    #[Value('root.firstLevelArray')]
    private array $smallList;

    public function getHello(): string
    {
        return $this->hello;
    }

    public function getWorld(): string
    {
        return $this->world;
    }

    public function getSmallList(): array
    {
        return $this->smallList;
    }
}
