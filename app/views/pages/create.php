<form action="/cards/create" method="post">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="name"><br>

    <label for="attack">Attack:</label><br>
    <input type="number" id="attack" name="attack"><br>

    <label for="defense">Defense:</label><br>
    <input type="number" id="defense" name="defense"><br>

    <label for="set">Set:</label><br>
    <input type="text" id="set" name="set"><br>

    <label for="rarity">Rarity:</label><br>
    <input type="text" id="rarity" name="rarity"><br>

    <label for="market_price">Market Price:</label><br>
    <input type="number" id="market_price" name="market_price"><br>
    <!-- Add other fields as needed -->
    <input type="submit" value="Create Card">
</form>
