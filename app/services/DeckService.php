<?php

namespace app\services;

use app\database\models\Deck;
use app\database\Database;

class DeckService
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $conn = $db->getConnection();
    }
    public function getDecksByUserId($userId)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM decks WHERE user_id = :user_id');
        $stmt->execute([':user_id' => $userId]);

        $decks = $stmt->fetchAll();

        return array_map(function($deck) {
            $stmt = $this->db->getConnection()->prepare('SELECT deck_cards.*, cards.name, cards.rarity FROM deck_cards JOIN cards ON deck_cards.card_id = cards.id WHERE deck_id = :deck_id');
            $stmt->execute([':deck_id' => $deck['id']]);

            $cards = $stmt->fetchAll();

            return new Deck($deck['id'], $deck['user_id'], $cards);
        }, $decks);
    }
    public function getDeckById($id)
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM decks WHERE id = :id');
        $stmt->execute([':id' => $id]);

        $deck = $stmt->fetch();

        if (!$deck) {
            return null;
        }

        $stmt = $this->db->getConnection()->prepare('SELECT * FROM deck_cards WHERE deck_id = :deck_id');
        $stmt->execute([':deck_id' => $id]);

        $cards = $stmt->fetchAll();

        return new Deck($deck['id'], $deck['user_id'], $cards);
    }

    public function createDeck($userId, $cards)
    {
        try {
            $this->db->getConnection()->beginTransaction();

            $stmt = $this->db->getConnection()->prepare('INSERT INTO decks (user_id) VALUES (:user_id)');
            $stmt->execute([':user_id' => $userId]);

            $deckId = $this->db->getConnection()->lastInsertId();

            $stmt = $this->db->getConnection()->prepare('INSERT INTO deck_cards (deck_id, card_id, quantity) VALUES (:deck_id, :card_id, :quantity)');

            foreach ($cards as $card) {
                $stmt->execute([
                    ':deck_id' => $deckId,
                    ':card_id' => $card['id'],
                    ':quantity' => $card['quantity'],
                ]);
            }

            $this->db->getConnection()->commit();

            return $this->getDeckById($deckId);
        } catch (\Exception $e) {

            if ($this->db->getConnection()->inTransaction()) {
                $this->db->getConnection()->rollBack();
            }

            throw $e;
        }
    }


    public function updateDeck($id, $cards)
    {
        // TODO: implement
    }

    public function deleteDeck($deckId)
    {
        $stmt = $this->db->getConnection()->prepare('DELETE FROM decks WHERE id = :id');
        $stmt->execute([':id' => $deckId]);

        return $stmt->rowCount() > 0;
    }
}