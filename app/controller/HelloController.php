<?php

namespace App\Controller;

use \OreOre\Core\View;

class HelloController extends \OreOre\Core\Controller
{
    public function index()
    {
        $view = new View('HelloWorld');
        $view->set('message', "hello");
        return $this->response(200, $view->render());
    }

    public function world()
    {
        $view = new View('HelloWorld');
        $view->set('message', "は？");
        return $this->response(200, $view->render());
    }
}

