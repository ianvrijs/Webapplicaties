<?php

namespace app\database\models;

use AllowDynamicProperties;
use app\database\Database;

#[AllowDynamicProperties] class Card
{
    public $id;
    public $name;
    public $attack;
    public $defense;
    public $rarity;
    public $market_price;
    public $set_name;

    public function __construct(array $values = [])
    {
        $this->id = $values['id'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->attack = $values['attack'] ?? null;
        $this->defense = $values['defense'] ?? null;
        $this->set_name = $values['set'] ?? null;
        $this->rarity = $values['rarity'] ?? null;
        $this->market_price = $values['market_price'] ?? null;
    }

    public static function getAllCards()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $stmt = $connection->query('SELECT id, name, attack, defense, set_name, rarity, market_price FROM cards');

        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'app\database\models\Card');
    }
    public function save()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $stmt = $connection->prepare('INSERT INTO cards (name, attack, defense, set_name, rarity, market_price) VALUES (:name, :attack, :defense, :set_name, :rarity, :market_price)');
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':attack', $this->attack);
        $stmt->bindParam(':defense', $this->defense);
        $stmt->bindParam(':set_name', $this->set_name);
        $stmt->bindParam(':rarity', $this->rarity);
        $stmt->bindParam(':market_price', $this->market_price);

        $stmt->execute();
    }
}