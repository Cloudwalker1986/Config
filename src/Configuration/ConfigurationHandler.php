<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration;

use Autowired\Handler\CustomHandlerInterface;
use Annotation\Config\Configuration\Attribute\Value;
use ReflectionClass;
use ReflectionException;

class ConfigurationHandler implements CustomHandlerInterface
{
    public function handle(string|object $object): null|object
    {
        if (is_string($object)) {
            return null;
        }

        $reflection = new ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            foreach ($property->getAttributes(Value::class) as $attribute) {
                $configuration = Config::getInstance();
                /** @var Value $value */
                $value = $attribute->newInstance();
                $property->setValue($object, $configuration->getValueByPath($value));
            }
        }

        return null;
    }
}
