<?php
GLOBAL $router;
GLOBAL $view;

use requests\MiddlewareStack;
use requests\Request;
use requests\Response;

$request = new Request();
$response = new Response();
$middlewareStack = new MiddlewareStack();

$router->add('/',function() use ($view){
    $controller = new \controllers\HomeController($view);
    return $controller->handle();
});

$router->add('/test/(\d+)', function($page) use ($view){
    $controller = new \controllers\TestController($view);
    return $controller->handle($page);
});

$router->add('/user/(\d+)', function($userId) use ($view){
    $controller = new \controllers\UserController($view);
    return $controller->handle($userId);
});

$middlewareStack->handle($request, $response);
$response->send();