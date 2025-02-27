<?php

namespace app\controllers;

use app\database\models\Card;
use app\services\SessionManager;
use app\views\View;

class CardController extends BaseController
{
    private SessionManager $sessionManager;
    public function __construct(View $view, SessionManager $sessionManager)
    {
        parent::__construct($view);
        $this->sessionManager = $sessionManager;
    }

    public function handle($id)
    {
        $this->setTitle('Cards Page');

        $cards = Card::getAllCards();
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display('pages/cards.php', ['cards' => $cards, 'page' => $id]);
        $this->view->display(__ROOT__ . '/app/templates/footer.php');

        $this->view->render();
    }

    public function showCreateForm()
    {
        $this->setTitle('Create Card');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display('pages/create.php');
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }

    public function createCard($request)
    {
        $cardData = [
            'name' => $request->post('name'),
            'attack' => $request->post('attack'),
            'defense' => $request->post('defense'),
            'set' => $request->post('set'),
            'rarity' => $request->post('rarity'),
            'market_price' => $request->post('market_price'),
        ];

        $card = new Card($cardData);

        $card->save();

        header('Location: /cards/'.$this->sessionManager->get('user_id'));    }
}