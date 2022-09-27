<?php
declare(strict_types=1);

namespace Annotation\ConfigTest\Configuration;

use Annotation\Config\Configuration\Config;
use Autowired\DependencyContainer;
use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
{
    public function flushDic(): self
    {
        DependencyContainer::getInstance()->flush();
        return $this;
    }

    public function flushConfig(): self
    {
        Config::getInstance()->destroy();
        return $this;
    }
}
