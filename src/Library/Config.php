<?php

declare(strict_types=1);

namespace App\Library;

use Exception;

class Config
{
    private static ?array $config = null;

    /**
     * Retrieves the configuration value or the entire configuration array.
     *
     * @param string|null $key The configuration key in dot notation (optional).
     * @return mixed The configuration value, entire array, or null if key not found.
     * @throws Exception If the config file is not found.
     */
    public static function get(?string $key = null): mixed
    {
        if (self::$config === null) {
            $configFile = dirname(__DIR__, 2) . '/config.php';
            if (!file_exists($configFile)) {
                throw new Exception("Config file not found: $configFile");
            }
            self::$config = include $configFile;
        }

        if ($key === null) {
            return self::$config;
        }

        $keys = explode('.', $key);
        $value = self::$config;

        foreach ($keys as $nestedKey) {
            if (!isset($value[$nestedKey])) {
                return null;
            }
            $value = $value[$nestedKey];
        }

        return $value;
    }
}
