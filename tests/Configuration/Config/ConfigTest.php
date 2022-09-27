<?php
declare(strict_types=1);

namespace Annotation\ConfigTest\Configuration\Config;

use Annotation\Config\Configuration\Exception\NoConfigFileException;
use Annotation\ConfigTest\Configuration\CommonTest;
use ReflectionProperty;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use Autowired\DependencyContainer;
use Annotation\Config\Configuration\Config;
use Autowired\Exception\InterfaceArgumentException;
use Annotation\Config\Configuration\Loader\ConfigLoader;
use Annotation\Config\Configuration\ConfigurationHandler;
use Annotation\ConfigTest\Configuration\Config\Example\ConfigExample;

class ConfigTest extends CommonTest
{
    /**
     * @test
     *
     * @dataProvider dataProviderResolve
     *
     * @throws InterfaceArgumentException
     * @throws ReflectionException
     */
    public function resolve(ConfigExample $expected, string $fileToParse): void
    {
        $container = DependencyContainer::getInstance();

        $arguments = [
            [$fileToParse],
            $container->get(ConfigLoader::class)
        ];
        $container->get(Config::class, argumentForHook: $arguments);

        $container->addCustomHandler(new ConfigurationHandler());

        /** @var ConfigExample $configExample */
        $configExample = $container->get(ConfigExample::class);

        $this->assertEquals($expected->getHello(), $configExample->getHello());
        $this->assertEquals($expected->getWorld(), $configExample->getWorld());
        $this->assertEquals($expected->getSmallList(), $configExample->getSmallList());

        $this->flushConfig()->flushDic();
    }

    /**
     * @throws ReflectionException
     */
    public function dataProviderResolve(): array
    {
        $expectedData = new ConfigExample();

        $propertyHello = new ReflectionProperty($expectedData, 'hello');
        $propertyHello->setValue($expectedData, 'Hello');
        $propertyWorld = new ReflectionProperty($expectedData, 'world');
        $propertyWorld->setValue($expectedData, 'World');
        $propertySmallList = new ReflectionProperty($expectedData, 'smallList');
        $propertySmallList->setValue($expectedData, ['valueOne', 'valueTwo', 'valueThree']);

        $file = __DIR__ . DIRECTORY_SEPARATOR . 'Example' . DIRECTORY_SEPARATOR . '%s';

        return [
            'config File is a yaml file' => [
                $expectedData,
                sprintf($file, 'test-for.yaml')
            ]
        ];
    }

    /**
     * @test
     *
     * @return void
     * @throws InterfaceArgumentException
     * @throws ReflectionException
     */
    public function invalidConfigFile(): void
    {
        $this->expectException(NoConfigFileException::class);
        $this->expectExceptionMessage('No config files were provided.');
        $container = DependencyContainer::getInstance();

        $arguments = [
            [],
            $container->get(ConfigLoader::class)
        ];
        $container->addCustomHandler(new ConfigurationHandler());
        $container->get(Config::class, argumentForHook: $arguments);
        $this->flushDic();
    }
}
