<?php

namespace OreOre\Core;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    public ?HttpHeader $header = null;

    public string $body = "";
    public string $uri = "";
    public string $path = "";
    public array $paths = [];
    public string $querystring = "";
    public string $method = "";
    protected array $_get = [];
    protected array $_post = [];
    protected array $_json = [];

    public function __construct()
    {
        $this->header = new HttpHeader();
        $this->body = file_get_contents('php://input');
        $this->uri = server('REQUEST_URI', '');
        $tmp = explode("?", $this->uri);
        $this->path = $tmp[0];
        $this->paths = array_filter(
            explode('/', trim($this->path, " \t\n\r\0\x0B/")),
            function(string $e): bool {
                return !!$e;
            }
        );
        if (count($tmp) > 1) {
            $this->querystring = $tmp[1];
        }
        parse_str($this->querystring, $this->_get);
        $this->method = strtoupper(server('REQUEST_METHOD', static::METHOD_GET));

        if ($this->header->contentType() === 'application/x-www-form-urlencoded') {
            parse_str($this->body, $this->_post);
        } else if ($this->header->contentType() === 'application/json') {
            $this->_json = json_decode($this->body, true);
        }
    }

    public function get(string $key, $default = null)
    {
        return arrayGet($this->_get, $key, $default);
    }

    public function post(string $key, $default = null)
    {
        return arrayGet($this->_post, $key,  $default);
    }

    public function json(string $key, $default = null)
    {
        return arrayGet($this->_json, $key,  $default);
    }
}

