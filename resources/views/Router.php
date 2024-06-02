<?php
namespace resources\views;
$request = $_SERVER['REQUEST_URI'];

class Router{

    private $routes = [];
    private $notFound;

    public function __construct(){
        $this->notFound = function($url){
            echo "404 - $url was not found!";
        };
    }

    public function add($url, $action){
        $this->routes[$url] = $action;
    }

    public function setNotFound($action){
        $this->notFound = $action;
    }

    public function dispatch(){
        $url = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $pattern => $action) {
            if (preg_match('#^' . $pattern . '$#', $url, $params)) {
                array_shift($params); // verwijder de volledige match
                return call_user_func_array($action, $params);
            }
        }
        call_user_func_array($this->notFound, [$url]);
    }
}