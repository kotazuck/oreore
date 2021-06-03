<?php

namespace OreOre\Core;

class HttpHeader
{
    protected $raw = null;
    protected $lower = [];

    public function __construct()
    {
        $this->raw = getallheaders();
        foreach ($this->raw as $key => $e) {
            $this->lower[strtolower($key)] = $e;
        }
    }

    public function get(string $key): string
    {
        return $this->lower[strtolower($key)] ?? "";
    }

    public function contentType(): string
    {
        return $this->get('content-type');
    }
}

