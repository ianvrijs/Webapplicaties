<?php

use app\services\Container;
use app\requests\Request;
use app\requests\Response;

$container = Container::getInstance();

try {
    $authenticationMiddleware = $container->get(app\middleware\AuthenticationMiddleware::class);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

$request = new Request();
$response = new Response($_SERVER);
$authenticationMiddleware->handle($request, $response);
?>


<h1>Home</h1>