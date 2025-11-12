<?php
include "DB1.php";
session_start();

if (isset($_POST['add'])) {
    $nimi = $conn->real_escape_string($_POST['name']);
    $hinta = (float)$_POST['price'];
    $kategoria_id = (int)$_POST['category_id'];
    $conn->query("INSERT INTO tuotteet (nimi, hinta, kategoria_id) VALUES ('$nimi', $hinta, $kategoria_id)");
}
$kategoriat = $conn->query("SELECT * FROM kategoriat");

$tilaukset = $conn->query("SELECT t.id, t.yhteensa, t.luotu, k.kayttajatunnus
                           FROM tilaukset t 
                           JOIN kayttajat k ON t.kayttaja_id = k.id 
                           ORDER BY t.luotu DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-PIZZA</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
    <h1>Admin hallinto</h1>

    <form method="post">
  Nimi: <input type="text" name="name" required>
  Hinta: <input type="number" step="0.01" name="price" required>
  Kategoria:
  <select name="category_id">
    <?php while ($k = $kategoriat->fetch_assoc()):  ?>
      <option value="<?= $k['id'] ?>"><?= $k['nimi'] ?></option>
    <?php endwhile; ?>
  </select>
  <button type="submit" name="add">Lisää</button>
</form>
<h2>Kaikki tilaukset</h2>
<?php while ($t = $tilaukset->fetch_assoc()):  ?>
  <h3>Tilaus #<?= $t['id'] ?>, (<?= $t['luotu'] ?>) - <?= number_format($t['yhteensa'], 2) ?> €, asiakas: <?= $t['kayttajatunnus'] ?></h3>
</ul>

<?php
$rivit = $conn->query("SELECT tr.maara, tr.hinta, tu.nimi
  FROM tilausrivit tr
  JOIN tuotteet tu ON tr.tuote_id = tu.id
  WHERE tr.tilaus_id = {$t['id']}");

while ($r = $rivit->fetch_assoc()) {
  echo "<li>. {$r['nimi']} ({$r['maara']} kpl) - " . number_format($r['hinta'], 2) . " €/kpl</li>";
}
?>
</ul>
<?php endwhile; ?>
</body>
</html>