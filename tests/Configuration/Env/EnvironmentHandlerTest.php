<?php
declare(strict_types=1);

namespace Annotation\ConfigTest\Configuration\Env;

use Annotation\Config\Configuration\Env\EnvFileResolver;
use Annotation\Config\Configuration\Env\EnvironmentHandler;
use Annotation\Config\Configuration\Exception\EnvFileNotFoundException;
use Annotation\ConfigTest\Configuration\CommonTest;
use Annotation\ConfigTest\Configuration\Env\Example\EnvConfig;
use Autowired\DependencyContainer;
use PHPUnit\Framework\TestCase;

class EnvironmentHandlerTest extends CommonTest
{
    /**
     * @test
     */
    public function resolve(): void
    {
        $container = DependencyContainer::getInstance();

        EnvFileResolver::getInstance()->resolve(__DIR__ . DIRECTORY_SEPARATOR . '.env');

        $container->addCustomHandler(new EnvironmentHandler());
        /** @var EnvConfig $envConfig */
        $envConfig = DependencyContainer::getInstance()->get(EnvConfig::class);

        $this->assertEquals(1, $envConfig->getValueOne());
        $this->assertEquals(2, $envConfig->getValueTwo());
        $this->assertEquals(3, $envConfig->getValueThree());
        $this->assertEquals('Hello World', $envConfig->getWord());
        $this->assertEquals('Should be removed', $envConfig->getSingleQuotes());
        $this->assertEquals([1,2,3,4], $envConfig->getArrayStyle());
        $this->flushDic();
    }

    /**
     * @test
     * @return void
     */
    public function invalidPath(): void
    {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'does-not-exists.env';

        $this->expectException(EnvFileNotFoundException::class);
        $this->expectExceptionMessage('There is .env file located behind the path ' . $file);
        EnvFileResolver::getInstance()->resolve(__DIR__ . DIRECTORY_SEPARATOR . 'does-not-exists.env');
    }
}
