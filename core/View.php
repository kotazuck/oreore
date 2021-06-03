<?php

namespace OreOre\Core;

class View
{

    protected static $global = [];

    protected $data = [];

    protected $file = "";
    protected $path = "";

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->path = VIEW_DIR . '/' . $file . '.php';
        if (!is_file($this->path)) {
            throw new RuntimeException('ViewNotFoundException: ' . $this->path);
        }
    }

    public function set($key, $val, $global = false)
    {
        if ($global) {
            static::$global[$key] = $val;
        } else {
            $this->data[$key] = $val;
        }
        return $this;
    }

    public function render(array $data = [])
    {
        $str = "";
        extract(static::$global);
        extract($this->data);
        extract($data);

        ob_start();
        include($this->path);
        $str = ob_get_clean();

        return $str;
    }

    public function __toString()
    {
        return $this->render();
    }
}

