<?php
declare(strict_types=1);

namespace Annotation\Config\Configuration\Loader;

class ConfigLoader
{
    public function load(string $file): array
    {
        $content = [];
        $extension = pathinfo($file)['extension'];
        if (in_array($extension, ['yml', 'yaml'])) {
            $content = yaml_parse_file($file);
        }

        return $content;
    }
}
