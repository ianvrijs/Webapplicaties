<?php

use app\requests\MiddlewareStack;
use app\requests\Request;
use app\requests\Response;

$container = \app\services\Container::getInstance();
$request = new Request();
$response = new Response();
$middlewareStack = new MiddlewareStack();

$router = $container->get('router');
$view = $container->get('view');

$router->add('/',function() use ($view){
    $controller = new \app\controllers\HomeController($view);
    return $controller->handle();
});

$router->add('/test/(\d+)', function($page) use ($view){
    $controller = new \app\controllers\TestController($view);
    return $controller->handle($page);
});

$router->add('/user/(\d+)', function($userId) use ($view){
    $controller = new \app\controllers\UserController($view);
    return $controller->handle($userId);
});

$middlewareStack->handle($request, $response);
$response->send();