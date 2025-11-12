<?php
include "DB1.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

if (!isset($_SESSION['kayttaja'])) {
    die("Kirjaudu sisään tehdäksesi tilauksen. <a href='login.php'>Kirjaudu</a>");
}

if (empty($_SESSION['cart'])) {
    die("Ostoskori on tyhjä. <a href='index.php'>Takaisin</a>");
}

$ids = implode(",", array_keys($_SESSION['cart']));
$result = $conn->query("SELECT * FROM tuotteet WHERE id IN ($ids)");

$total = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $qty = $_SESSION['cart'][$row['id']];
    $line = $qty * $row['hinta'];
    $total += $line;
    $items[] = [
        "id" => $row['id'],
        "hinta" => $row['hinta'],
        "maara" => $qty
    ];
}
$conn->query("INSERT INTO tilaukset (kayttaja_id, yhteensa) VALUES ({$_SESSION['kayttaja']['id']}, $total)");
$tilausId = $conn->insert_id;

foreach ($items as $it) {
    $conn->query("INSERT INTO tilausrivit (tilaus_id, tuote_id, maara, hinta)
    VALUES ($tilausId, {$it['id']}, {$it['maara']}, {$it['hinta']})");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tilaus vahvistettu</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
    <h1>Tilaus valmis!</h1>
    <p>Tilauksen ID: <?=$tilausId ?></p>
    <p><a href="index.php">Takaisin kauppaan</a></p>
</body>
</html>
