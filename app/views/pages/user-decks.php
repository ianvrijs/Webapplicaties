<?php
use app\services\UserService;
use app\database\Database;
use app\services\Container;

$container = Container::getInstance();
$session = $container->get('session');

if ($session->exists('user_id')) {
$userId = $session->get('user_id');
$userService = new UserService(new Database());
$user = $userService->getUserById($userId);
$userRole = $user->role;
} else {
$userRole = null;
}
?>

<h2>Your decks:</h2>
<?php foreach ($decks as $deck): ?>
    <div>
        <h2>Deck ID: <?php echo $deck->id; ?></h2>
        <ul>
            <?php foreach ($deck->cards as $card): ?>
                <li>Card Name: <?php echo $card['name']; ?>, Rarity: <?php echo $card['rarity']; ?>, Quantity: <?php echo $card['quantity']; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php
        if($userRole === 'admin') {
            echo '
        <form action="/decks/delete/<?php echo $deck->id; ?>" method="post">
            <input type="submit" value="Delete Deck">
        </form>';
        }?>
    </div>
<?php endforeach; ?>