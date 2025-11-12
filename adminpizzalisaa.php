<?php
session_start();
include "DB1.php";


    if (isset($_POST['add'])) {
        $nimi = $conn->real_escape_string($_POST['nimi']);
        $hinta = (float)$_POST['hinta'];
        $kuva = $conn->real_escape_string($_POST['kuva_url']);
        $kategoria_id = (int)$_POST['kategoria_id'];

        $conn->query("INSERT INTO tuotteet (nimi, hinta, kuva_url, kategoria_id) VALUES ('$nimi', '$hinta', '$kuva', '$kategoria_id')");
        
    }

    $kategoriat = $conn->query("SELECT * FROM kategoriat");
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tyylipizza.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<form method="post">
  Nimi: <input type="text" name="nimi" required><br><br>
  Hinta: <input type="number" step="0.01" name="hinta" required><br><br>
  Kategoria:
  <select name="kategoria_id">
    <?php while ($k = $kategoriat->fetch_assoc()): ?>
      <option value="<?= $k['id'] ?>"><?= $k['nimi'] ?></option>
    <?php endwhile; ?>
  </select><br><br>
  Kuvan tiedostonimi: <input type="text" name="kuva_url"><br><br>
  <button type="submit" name="add">Lisää tuote</button>
</form>

