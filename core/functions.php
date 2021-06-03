<?php

if (!function_exists('arrayGet')) {
    function arrayGet(array $arr, string $key, $default = null)
    {
        if (isset($arr[$key])) {
            return $arr[$key];
        }
        return $default;
    }
}

if (!function_exists('server')) {
    function server(string $key, $default = null)
    {
        return arrayGet($_SERVER, $key, $default);
    }
}

if (!function_exists('recursiveFile')) {
    function recursiveFile($dir, $callback) {
        foreach (glob($dir . '/*') as $f) {
            if (is_dir($f)) {
                recursiveFile($f, $callback);
            } else {
                $callback($f);
            }
        }
    }
}
