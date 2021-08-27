<?php

namespace Mar4hk0\Fakers;

use Mar4hk0\Exceptions\ExceptionConfig;

class Config
{
    public const ROOT_PATH = __DIR__ . '/../../config.yaml';

    /**
     * @throws ExceptionConfig
     */
    public static function create(): void
    {
        if (empty(file_exists(self::ROOT_PATH))) {
            throw new ExceptionConfig(self::ROOT_PATH . ' does not exit.');
        }

        static::load(self::ROOT_PATH);
    }

    private static function load(string $filePath): void
    {
        $data = static::process($filePath);
        foreach ($data as $key => $item) {
            $_ENV[$key] = $item;
        }
    }

    /**
     * @throws ExceptionConfig
     */
    private static function process(string $filePath): array
    {
        $data = [];

        foreach (self::readFile($filePath) as $varName => $varValue) {
            if (empty($varValue)) {
                throw new ExceptionConfig('Config has empty variable "' . $varName . '"');
            }
            $data[$varName] = $varValue;
        }

        return $data;
    }

    private static function readFile(string $filePath): array
    {
        return \Symfony\Component\Yaml\Yaml::parseFile($filePath);
    }

}
