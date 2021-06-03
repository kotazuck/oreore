<?php

namespace OreOre\Core;

class Response
{
    protected $status = 200;
    protected $body = "";
    protected $headers = [];

    public function __construct(int $status, string $body, array $headers)
    {
        $this->status = $status;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function send()
    {
        http_response_code($this->status);
        foreach ($this->headers as $key => $val) {
            header($key . ':' . $val);
        }
        echo $this->body;
        exit(0);
    }
}

