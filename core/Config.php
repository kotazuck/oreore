<?php

namespace OreOre\Core;

class Config
{
    static array $configs = [];

    public static function load(string $name)
    {
        if (isset(static::$configs[$name])) {
            return static::$configs[$name];
        }
        if (is_file(CONFIG_DIR . '/' . $name . '.php')) {
            $arr = include(CONFIG_DIR . '/' . $name . '.php');
            static::$configs[$name] = new Config($arr);
            return static::$configs[$name];
        }
        return null;
    }

    protected array $arr = [];

    protected function __construct($arr)
    {
        $this->arr = $arr;
    }

    public function get($key, $default = null)
    {
        return $this->arr[$key] ?? $default;
    }
}

