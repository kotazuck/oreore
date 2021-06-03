<?php

namespace App\Controller;

use \OreOre\Core\View;

class RootController extends \OreOre\Core\Controller
{
    public function index()
    {
        $view = new View('HelloWorld');
        $view->set('message', "オレオレフレームワークへようこそ");
        return $this->response(200, $view->render());
    }

    public function oreore()
    {
        return $this->response(200, 'oreore');
    }
}
