<?php

use app\middleware\MiddlewareStack;
use app\requests\Request;
use app\requests\Response;

$container = \app\services\Container::getInstance();
$request = new Request();
$response = new Response();
$middlewareStack = new MiddlewareStack();
$authMiddleware = new \app\middleware\AuthenticationMiddleware($container->get(\app\services\AuthService::class));
$sessionManager = $container->get(\app\services\SessionManager::class);



$router = $container->get('router');
$view = $container->get('view');

$router->add('/',function() use ($container){
    $controller =  $container->get(\app\controllers\HomeController::class);
    return $controller->handle();
}, 'GET', $authMiddleware);

$router->add('/login', function() use ($container) {
    $controller = $container->get(\app\controllers\AuthController::class);
    return $controller->showLoginForm();
}, 'GET');

$router->add('/login', function() use ($container, $request, $sessionManager) {
    $controller = $container->get(\app\controllers\AuthController::class);
    $response = $controller->login($request);


    if ($response->getStatus() == 200) {
        $username = $request->post('username');
        $user = $container->get(\app\services\UserService::class)->getUserByUsername($username);
        $sessionManager->set('user_id', $user->id);
    }

    return $response;
}, 'POST');

$router->add('/test/(\d+)', function($page) use ($container){
    $controller = $container->get(\app\controllers\TestController::class);
    return $controller->handle($page);
}, 'GET', $authMiddleware);

$router->add('/user/(\d+)', function($userId) use ($container){
    $controller = $container->get(\app\controllers\UserController::class);
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

$router->add('/cards/(\d+)', function($userId) use ($container) {
    $controller = $container->get(\app\controllers\CardController::class);
    return $controller->handle($userId);
}, 'GET', $authMiddleware);

$router->add('/cards/create', function() use ($container, $sessionManager) {
    if (!$sessionManager->exists('user_id')) {
        $response = new \app\requests\Response();
        $response->setStatus(401);
        $response->setBody('Unauthorized');
        return $response;
    }

    $userId = $sessionManager->get('user_id');

    $user = $container->get(\app\services\UserService::class)->getUserById($userId);
    if($user->role !== 'admin' && $user->role !== 'premium') {
        $response = new \app\requests\Response();
        $response->setStatus(403);
        $response->setBody('Forbidden');
        return $response;
    }

    $controller = $container->get(\app\controllers\CardController::class);
    return $controller->showCreateForm();
}, 'GET', $authMiddleware);

$router->add('/cards/create', function() use ($container, $request) {
    $controller = $container->get(\app\controllers\CardController::class);
    return $controller->createCard($request);
}, 'POST', $authMiddleware);

$router->add('/decks/create', function() use ($container, $sessionManager) {
    if (!$sessionManager->exists('user_id')) {
        $response = new \app\requests\Response();
        $response->setStatus(401);
        $response->setBody('Unauthorized');
        return $response;
    }

    $userId = $sessionManager->get('user_id');

    $user = $container->get(\app\services\UserService::class)->getUserById($userId);
    if($user->role !== 'admin' && $user->role !== 'premium') {
        $response = new \app\requests\Response();
        $response->setStatus(403);
        $response->setBody('Forbidden');
        return $response;
    }

    $controller = $container->get(\app\controllers\DeckController::class);
    return $controller->showCreateForm();
}, 'GET', $authMiddleware);

$router->add('/decks/create', function() use ($container) {
    $controller = $container->get(\app\controllers\DeckController::class);
    return $controller->createDeck();
}, 'POST');

$router->add('/decks', function() use ($container) {
    $controller = $container->get(\app\controllers\DeckController::class);
    return $controller->showUserDecks();
}, 'GET', $authMiddleware);

$router->add('/decks/delete/(\d+)', function($deckId) use ($container) {
    $controller = $container->get(\app\controllers\DeckController::class);
    return $controller->deleteDeck($deckId);
}, 'POST', $authMiddleware);

//TODO: implement delete cards
$router->add('/cards/delete/(\d+)', function($cardId) use ($container) {
    $controller = $container->get(\app\controllers\CardController::class);
    return $controller->deleteCard($cardId);
}, 'POST', $authMiddleware);



$middlewareStack->handle($request, $response);
$response->send();