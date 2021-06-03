<?php

namespace OreOre\Core;

define("CORE_DIR", __DIR__);
define("ROOT_DIR", dirname(__DIR__));
define("APP_DIR", ROOT_DIR . '/app');

define("CONFIG_DIR", APP_DIR . '/config');
define("CONTROLLER_DIR", APP_DIR . '/controller');
define("VIEW_DIR", APP_DIR . '/view');

require(__DIR__ . '/RuntimeException.php');
require(__DIR__ . '/functions.php');
require(__DIR__ . '/Config.php');
require(__DIR__ . '/HttpHeader.php');
require(__DIR__ . '/Request.php');
require(__DIR__ . '/Response.php');
require(__DIR__ . '/View.php');
require(__DIR__ . '/Controller.php');
require(__DIR__ . '/Database.php');

Database::init();

spl_autoload_register(function($name) {
    $path = str_replace('\\', '/', $name);
    $dir = ROOT_DIR . '/' . dirname(strtolower($path));
    $name = basename($path);
    $file = $dir . '/' . $name . '.php';
    if (is_file($file)) {
        include_once $file;
    }
});

$request = new Request();
$config = Config::load('config');

$routes = $config->get('routes');

$response = null;

foreach ($routes as $path => $c) {
    if (strpos($request->path, $path) !== false) {
        $p = str_replace($path, '', $request->path);
        $paths = array_filter(
            explode('/', trim($p, " \t\n\r\0\x0B/")),
            function($e) {
                return !!$e;
            }
        );
        $controller = new $c($request);
        if (!$paths) {
            if (method_exists($controller, 'index')) {
                call_user_func([$controller, 'before']);
                $response = call_user_func_array([$controller, 'index'], $paths);
                call_user_func([$controller, 'after']);
            }
        } else {
            if (method_exists($controller, $paths[0])) {
                call_user_func([$controller, 'before']);
                $response = call_user_func_array([$controller, $paths[0]], array_slice($paths, 1));
                call_user_func([$controller, 'after']);
            }
        }
        if ($response) {
            break;
        }
    }
}

if ($response) {
    $response->send();
    exit(0);
} else {
    http_response_code(404);
}

