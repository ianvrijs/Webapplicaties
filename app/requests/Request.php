<?php

namespace app\requests;

class Request
{
    private $uri;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function get($key)
    {
        return $_REQUEST[$key] ?? null;
    }
}