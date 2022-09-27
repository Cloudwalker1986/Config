<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration\Env;

use Autowired\Handler\CustomHandlerInterface;
use Annotation\Config\Configuration\Attribute\Env;
use ReflectionProperty;

class EnvironmentHandler implements CustomHandlerInterface
{
    public function handle(string|object $object): null|object
    {
        if (is_string($object)) {
            return null;
        }

        $reflection = new \ReflectionClass($object);

        foreach ($reflection->getProperties() as $property) {
            $attribute = $property->getAttributes(Env::class);

            if (empty($attribute)) {
                continue;
            }
            $this->setValue($attribute[0], $property, $object);

        }

        return null;
    }

    /**
     * @param $attribute
     * @param ReflectionProperty $property
     * @param object $object
     * @return void
     */
    protected function setValue($attribute, ReflectionProperty $property, object $object): void
    {
        /** @var Env $env */
        $env = $attribute->newInstance();

        $property->setValue(
            $object,
            $this->getCastedValue(
                trim(trim($env->getValue(), '"'), "'"),
                $property->getName(),
                $property->getType()?->getName(),
            )
        );
    }

    private function getCastedValue(string $value, string $propertyName, string $type = ''): int|bool|array|string|float
    {
        return match($type) {
            'int' => (int) $value,
            'bool' => (bool) $value,
            'array' => explode(',', $value),
            'float' => (float) $value,
            'string' => $value,
            default => throw new \InvalidArgumentException('Undefined type for ENV property ' . $propertyName)
        };
    }
}
