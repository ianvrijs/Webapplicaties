<?php

namespace app\database\models;
class DeckCard
{
    public $id;
    public $deckId;
    public $cardId;
    public $quantity;

    public function __construct($id, $deckId, $cardId, $quantity)
    {
        $this->id = $id;
        $this->deckId = $deckId;
        $this->cardId = $cardId;
        $this->quantity = $quantity;
    }

}