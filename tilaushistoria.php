<?php
session_start();

include "DB1.php";

if (!isset($_SESSION['kayttaja'])) {
    die("Kirjaudu sisään nähdäksesi tilaushistorian.");
}

//tallenetaan id muuttujaan
$kayttajaId = $_SESSION['kayttaja']['id'];

$result = $conn->query("SELECT * FROM tilaukset WHERE kayttaja_id = $kayttajaId ORDER BY luotu DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tilaushistoria</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
    <h1>tilaushistoria</h1>

    <?php
    while ($tilaus = $result->fetch_assoc()) {
        echo "<h3>Tilaus #{$tilaus['id']} ({$tilaus['luotu']}) - "
        . number_format($tilaus['yhteensa'], 2) . " €</h3>";

        $rivit = $conn->query("
        SELECT tr.maara, tr.hinta, tu.nimi FROM tilausrivit tr JOIN tuotteet tu ON tr.tuote_id = tu.id WHERE tr.tilaus_id = {$tilaus['id']}
        ");
        echo "<ul>";
        while ($rivi = $rivit->fetch_assoc()) {
            echo "<li>{$rivi['nimi']} ({$rivi['maara']} kpl) -"
            . number_format($rivi['hinta'], 2) . " €kpl</li>";
        }
        echo "</ul>";
    }
    ?>
    <p><a href="index.php">Takaisin kauppaan</a></p>
</body>
</html>
