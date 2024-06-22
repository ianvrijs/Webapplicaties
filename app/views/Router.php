<?php
namespace app\views;

use app\requests\Request;
use app\requests\Response;

class Router{

    private $routes = [];
    private $middlewares = [];
    private $notFound;

    public function __construct(){
        $this->notFound = function($url){
            echo "404 - $url was not found!";
        };
    }

    public function add($url, $action, $method = 'GET', $middleware = null){
        $this->routes[$method][$url] = $action;
        if ($middleware) {
            $this->middlewares[$method][$url] = $middleware;
        }
    }

    public function setNotFound($action){
        $this->notFound = $action;
    }

    public function dispatch(){
        $url = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $pattern => $action) {
                if (preg_match('#^' . $pattern . '$#', $url, $params)) {
                    array_shift($params); // remove the full match
                    if (isset($this->middlewares[$method][$pattern])) {
                        $middleware = $this->middlewares[$method][$pattern];
                        $middleware->handle(new Request(), new Response());
                    }
                    return call_user_func_array($action, $params);
                }
            }
        }
        call_user_func_array($this->notFound, [$url]);
    }
}