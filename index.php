<?php
//Global is onnodig, echter maakt geeft de editor een rood golfje aan zonder de global..
global $view;
global $router;

require('config.php');
require(__DIR__ . '/app/bootstrap.php');
require(__ROOT__ . '/routes/routes.php');


$router->dispatch();
