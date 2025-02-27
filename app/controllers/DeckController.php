<?php

namespace app\controllers;

use app\services\DeckService;
use app\requests\Response;
use app\views\View;

class DeckController extends BaseController
{
    private $deckService;
    protected $view;

    public function __construct(DeckService $deckService, View $view)
    {
        parent::__construct($view);
        $this->deckService = $deckService;
        $this->view = $view;
    }

    public function showCreateForm()
    {
        $this->setTitle('Create Deck');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display('pages/create-deck.php');
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }
    public function showUserDecks()
    {
        $sessionManager = new \app\services\SessionManager();
        $userId = $sessionManager->get('user_id');
        $decks = $this->deckService->getDecksByUserId($userId);
        $this->setTitle('User Decks');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display('pages/user-decks.php', ['decks' => $decks]);
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }

    public function createDeck()
    {
        $sessionManager = new \app\services\SessionManager();
        $userId = $sessionManager->get('user_id');
        $cards = $_POST['cards'];

        $deck = $this->deckService->createDeck($userId, $cards);

        header('Location: /decks');
    }
    public function updateDeck($id)
    {
        //TODO: implement
    }

    public function deleteDeck($deckId)
    {
        $this->deckService->deleteDeck($deckId);

        header('Location: /decks');
    }
}