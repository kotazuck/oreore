<?php

namespace OreOre\Core;

class Controller
{
    protected $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function before()
    {
    }

    public function after()
    {
    }

    protected function response(int $status, string|View $body, array $headers = [])
    {
        return new Response($status, $body, $headers);
    }
}

