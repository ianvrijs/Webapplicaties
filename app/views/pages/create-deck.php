<form action="/decks/create" method="post">
    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">

    <h2>Voeg kaarten toe aan het deck</h2>

    <div class="card">
        <label for="card_id">Card ID</label>
        <input type="text" name="cards[0][id]" id="card_id">

        <label for="quantity">Quantity</label>
        <input type="number" name="cards[0][quantity]" id="quantity">
    </div>

    <input type="submit" value="Create Deck">
</form>