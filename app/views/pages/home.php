<h1>Home</h1>

<?php


$hour = date('H');

if ($hour >= 6 && $hour < 12) {
    echo "<h2>Goedemorgen!</h2>";
} elseif ($hour >= 12 && $hour < 18) {
    echo "<h2>Goedemiddag!</h2>";
} elseif ($hour >= 18 && $hour < 22) {
    echo "<h2>Goedenavond!</h2>";
} else {
    echo "<h2>Goedenacht!</h2>";
}

?>