<?php

namespace app\requests;

class Response
{
    private $status = 200;
    private $body = '';

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function send()
    {
        http_response_code($this->status);
        echo $this->body;
    }
}