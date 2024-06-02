<?php
namespace app\requests;

class Response
{
    private $content;

    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function send()
    {
        echo $this->content;
    }
}