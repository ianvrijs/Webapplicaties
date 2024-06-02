<?php

require(__ROOT__ . '/Autoload.php');

$autoloader = new Autoload();
spl_autoload_register([$autoloader, 'load']);

$view = new \app\views\View( new \app\views\ViewLoader(__ROOT__.'/resources/views/') );
$router = new \app\views\Router();