<?php

namespace app\database\models;

class Deck
{
    public $id;
    public $userId;
    public $cards = [];

    public function __construct($id, $userId, $cards = [])
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->cards = $cards;
    }
}