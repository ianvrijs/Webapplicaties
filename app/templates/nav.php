<?php

use app\services\UserService;
use app\database\Database;
use app\services\Container;

$container = Container::getInstance();
try {
    $session = $container->get('session');
} catch (Exception $e) {
}

if ($session->exists('user_id')) {
    $userId = $session->get('user_id');
    $userService = new UserService(new Database());
    $user = $userService->getUserById($userId);
    $userRole = $user->role;
} else {
    $userRole = null;
}

?>

<nav class="nav">
    <ul>
        <?php

        if ($session->exists('user_id')) {
            echo '<li><a href="/" >Home</a></li>';
            echo '<li><a href="/cards/' . $session->get('user_id') . '">Cards</a></li>';
            echo '<li><a href="/decks">Decks</a></li>';
            if ($userRole === 'admin' || $userRole === 'premium') {
                echo '<li><a href="/cards/create">Create Card</a></li>';
                echo '<li><a href="/decks/create">Create Deck</a></li>';
            }
            echo '<li><a href="/user/' . $session->get('user_id') .'">User</a></li>';
//            echo '<li><a href="/test/' . $session->get('user_id') .'">Test</a></li>'; // Test route :)
            echo '<li><form action="/logout" method="post">
            <input type="submit" value="Logout">
        </form></li>';
        } else {
            echo '<li><a href="/login">Login</a></li>';
            echo '<li><a href="/register">Register</a></li>';
        }
        ?>

    </ul>
</nav>