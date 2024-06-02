<?php

require(__ROOT__ . '/public/Autoload.class.php');

$autoloader = new Autoload();
spl_autoload_register([$autoloader, 'load']);

$view = new \resources\views\View( new \resources\views\ViewLoader(__ROOT__.'/resources/views/') );
$router = new \resources\views\Router();