<?php
include "DB1.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_POST['add'])) {
    $id= (INT)$_POST['product_id'];
    $qty = (INT)$_POST['quantity'];
    if ($qty > 0) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 0;
        }
        $_SESSION['cart'][$id] += $qty;
    }
}

if (isset($_POST['remove'])) {
    $id = (INT)$_POST['remove'];
    unset($_SESSION['cart'][$id]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ostoskori</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
<h1>Ostoskori</h1>
<?php
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $result = $conn->query("SELECT * FROM tuotteet WHERE id IN ($ids)");
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $qty = $_SESSION['cart'][$row['id']];
        $total += $row['hinta'] * $qty;
        echo "<p>{$row['nimi']} ({$qty} kpl) - " . number_format($row['hinta'], 2) . " € 
            <form method='post' style='display:inline'>
                <button type='submit' name='remove' value='{$row['id']}'>Poista</button>
            </form></p>";
    }
    echo "<p>Yhteensä: " . number_format($total, 2) . " €</p>";
    echo "<p><a href='kassalle.php'>Siirry kassalle</a></p>";
} else {
    echo "<p>Ostoskori on tyhjä.</p>";
}
?>
<p><a href='index.php'>Takaisin kauppaan</a></p>
</body>
</html>
