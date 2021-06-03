<?php

namespace OreOre\Core;

class Database
{
    static $instance = null;

    public static function connection($name = 'default')
    {
        $db = static::$instance;
        if (!isset($db->connections[$name])) {
            $dsn = $db->config->get($name);
            if (!$dsn) {
                throw new RuntimeException('DatabaseException: ' . $name . ' config not found');
            }
            static::$instance->connections[$name] = new \PDO($dsn);
        }
        return $db->connections[$name];
    }


    public static function init()
    {
        static::$instance = new static();
    }

    protected $config = null;
    protected $connections = [];

    protected function __construct() 
    {
        $this->config = Config::load('database');
    }
}

