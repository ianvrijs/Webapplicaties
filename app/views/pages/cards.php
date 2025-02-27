<?php
$cards = $data['cards'];
foreach ($cards as $card) {
    echo "<h2>{$card->name}</h2>";
    echo "<p>Attack: {$card->attack}</p>";
    echo "<p>Defense: {$card->defense}</p>";
    echo "<p>Set: {$card->set_name}</p>";
    echo "<p>Rarity: {$card->rarity}</p>";
    echo "<p>Market Price: {$card->market_price}</p>";
    echo "<hr>";
}