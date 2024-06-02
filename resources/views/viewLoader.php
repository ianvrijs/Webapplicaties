<?php
namespace resources\views;
use AllowDynamicProperties;

#[AllowDynamicProperties] class ViewLoader{

    public function __construct($path){
        $this->path = $path;
    }
    public function load($viewName, $data = []){
        extract($data);
        ob_start();
        require $viewName;
        $content = ob_get_clean();
        return $content;
    }
}