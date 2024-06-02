<?php

namespace requests;

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
}