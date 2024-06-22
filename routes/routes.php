<?php

use app\middleware\MiddlewareStack;
use app\requests\Request;
use app\requests\Response;

$container = \app\services\Container::getInstance();
$request = new Request();
$response = new Response();
$middlewareStack = new MiddlewareStack();
$authMiddleware = new \app\middleware\AuthenticationMiddleware($container->get(\app\services\AuthService::class));

$router = $container->get('router');
$view = $container->get('view');

$router->add('/',function() use ($view){
    $controller = new \app\controllers\HomeController($view);
    return $controller->handle();
}, 'GET', $authMiddleware);

$router->add('/login', function() use ($container) {
    $controller = $container->get(\app\controllers\AuthController::class);
    return $controller->showLoginForm();
}, 'GET');

$router->add('/login', function() use ($container, $request) {
    $controller = $container->get(\app\controllers\AuthController::class);
    return $controller->login($request);
}, 'POST');

$router->add('/test/(\d+)', function($page) use ($view){
    $controller = new \app\controllers\TestController($view);
    return $controller->handle($page);
}, 'GET', $authMiddleware);

$router->add('/user/(\d+)', function($userId) use ($view){
    $controller = new \app\controllers\UserController($view);
    return $controller->handle($userId);
}, 'GET', $authMiddleware);

$router->add('/register', function() use ($container) {
    $controller = $container->get(\app\controllers\AuthController::class);
    return $controller->showRegistrationForm();
}, 'GET');

$router->add('/register', function() use ($container, $request) {
    $controller = $container->get(\app\controllers\AuthController::class);
    return $controller->register($request);
}, 'POST');

$router->add('/logout', function() use ($container) {
    $controller = $container->get(\app\controllers\AuthController::class);
    return $controller->logout();
}, 'POST', $authMiddleware);

$middlewareStack->handle($request, $response);
$response->send();