<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration;

use Annotation\Config\Configuration\Exception\NoConfigFileException;
use Annotation\Config\Configuration\Loader\ConfigLoader;
use Annotation\Config\Configuration\Attribute\Value;
use Autowired\Attribute\BeforeConstruct;
use Autowired\Utils\Collection;
use Autowired\Utils\Map;

class Config
{
    private static ?Config $instance = null;

    private array $config;

    public function __construct(array $files, ConfigLoader $loader)
    {
        if (empty($files)) {
            throw new NoConfigFileException(
                'No config files were provided.'
            );
        }

        $config = [];

        foreach ($files as $file) {
            $loadedConfig = $loader->load($file);
            $config = array_merge_recursive($config, $loadedConfig);
        }

        $this->config = $config;
    }

    public function getValueByPath(Value $value): string|int|float|array|Map|Collection|null|bool
    {
        return $this->parse($value->getPath());
    }

    private function parse(string $path): string|int|float|array|Map|Collection|null|bool
    {
        $value = null;
        $pathLevelList = explode('.', $path);
        $max = count($pathLevelList) - 1;
        $iterator = $this->config;
        for ($i = 0; $i <= $max; $i++) {
            if (isset($iterator[$pathLevelList[$i]])) {
                if (is_array($iterator[$pathLevelList[$i]])) {
                    $iterator = $iterator[$pathLevelList[$i]];
                    $value = $iterator;
                } else {
                    $value = $iterator[$pathLevelList[$i]];
                }
            } else {
                $value = null;
            }
        }
        return $value;
    }

    public function destroy(): void
    {
        $this->config = [];
        self::$instance = null;
    }

    #[BeforeConstruct]
    public static function getInstance(array $files = [], ?ConfigLoader  $loader = null): Config
    {
        if (empty(self::$instance)) {
            self::$instance = new self($files, $loader);
        }
        return self::$instance;
    }
}
