<?php
include "DB1.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza-kauppa</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
    <h1>Tervetuloa Pizzeriaan!</h1>

    <?php
    $result = $conn->query("
        SELECT t.id, t.nimi, t.hinta, t.kuva_url, k.nimi AS kategoria
        FROM tuotteet t
        JOIN kategoriat k ON t.kategoria_id = k.id
        ORDER BY k.nimi DESC
    ");
    
    
    $currentCat = "";
    
  
    while ($row = $result->fetch_assoc()) {
       
        if ($currentCat != $row['kategoria']) {
            $currentCat = $row['kategoria'];
            echo "<h2>{$currentCat}</h2>";
        }
    
      
      echo "<form method='post' action='ostoskori.php'>
      <img src='{$row['kuva_url']}' alt='{$row['nimi']}' style='width:150px'><br>
      {$row['nimi']} - {$row['hinta']} €
      <input type='hidden' name='product_id' value='{$row['id']}'>
      <input type='number' name='quantity' value='1' min='1'>
      <button type='submit' name='add'>Lisää koriin</button>
      </form>";
     }
    ?>
    
    <p><a href="ostoskori.php">Ostoskori</a></p>
    <p><a href="tilaushistoria.php">Oma tilaushistoria</a></p>

    <?php
    if (isset($_SESSION['kayttaja'])): ?>
    <p>Kirjautunut: <?= $_SESSION['kayttaja']['kayttajatunnus'] ?>
    (<a href="login.php">Kirjaudu</a>)</p>
    <?php else: ?>
        <p><a href="login.php">Kirjaudu</a> | <a href="rekisterointi1.php">Rekisteröidy</a></p>
        <?php endif; ?>

</body>
</html>