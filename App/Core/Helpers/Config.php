<?php

declare(strict_types = 1);

namespace App\Core\Helpers;

final class Config
{
    private static array $config;

    public function __construct(array $config = [])
    {
        static::$config = $config;
    }

    public static function get($offset = null)
    {
        if ($offset === null) {
            return static::$config;
        }

        if (isset(static::$config[$offset]) === false) {
            return static::$config;
        }

        return static::$config[$offset];
    }
}