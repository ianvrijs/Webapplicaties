<?php

namespace app\controllers;

use app\services\Container;
use app\views\View;

class UserController extends BaseController {
    private $container;
    public function __construct(View $view, Container $container)
    {
        parent::__construct($view, $container);
        $this->container = $container;
    }

    public function handle($userId) {
        $userService = $this->container->get(\app\services\UserService::class);
        $deckService = $this->container->get(\app\services\DeckService::class);

        $user = $userService->getUserById($userId);
        $decks = $deckService->getDecksByUserId($userId);

        $totalCards = 0;
        foreach ($decks as $deck) {
            $totalCards += count($deck->cards);
        }

        $this->setTitle('User Page');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display(__ROOT__ . '/app/views/pages/user.php', [
            'user' => $user,
            'totalDecks' => count($decks),
            'totalCards' => $totalCards,
        ]);
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }

}