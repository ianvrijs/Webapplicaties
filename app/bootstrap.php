<?php

require(__ROOT__ . '/Autoload.php');

$autoloader = new Autoload();
spl_autoload_register([$autoloader, 'load']);

$container = \app\services\Container::getInstance();

$viewLoader = new \app\views\ViewLoader(__ROOT__.'/resources/views/');
$view = new \app\views\View($viewLoader);
$router = new \app\views\Router();

$container->set('view', $view);
$container->set('router', $router);