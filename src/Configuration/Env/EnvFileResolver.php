<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration\Env;

use Annotation\Config\Configuration\Exception\EnvFileNotFoundException;

class EnvFileResolver
{
    private static ?EnvFileResolver $instance = null;

    public static function getInstance(): EnvFileResolver
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function resolve($filePath): void
    {
        if (!file_exists($filePath)) {
            throw new EnvFileNotFoundException(
                'There is .env file located behind the path ' . $filePath
            );
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
