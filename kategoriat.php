<?php
session_start();

include "DB1.php";


//Lisää toiminto "add" parametri
if(isset($_POST['add'])) {

    //Ottaa lähetetyn datan tateen
    var_dump($_POST);
    $nimi = trim($_POST['nimi']);

   echo "Lomake lähetetty!<br>";

    //Tietokanta insert into
    $stmt = $conn->prepare("INSERT INTO kategoriat (nimi) VALUES (?)");
    $stmt->bind_param("s", $nimi); //toteuttaa käskyn
    if($stmt->execute()) {
      $_SESSION["msg"] =["text" => "kategoria lisättiin onnistuneesti", "type" => "success"];
    } else {
        $_SESSION["msg"] =["text" => "kategoriaa ei voitu lisätä onnistuneesti", "type" => "error"];
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
}

//KATEGORIA muokkaa
if(isset($_POST['muokkaa'])) {
$id = (int)$_POST['id'];
$nimi = trim($_POST['nimi']);

    //Tietokanta UPDATE KATEGORIA
    $stmt = $conn->prepare("UPDATE kategoriat SET nimi=? WHERE id=?");
    $stmt->bind_param("si", $nimi, $id);
    if($stmt->execute()) {
      $_SESSION["msg"] =["text" => "kategoria muokattiin onnistuneesti", "type" => "success"];
    } else {
        $_SESSION["msg"] =["text" => "kategoriaa ei voitu muokata", "type" => "error"];
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


//Poista toiminto
if(isset($_POST['poista'])) {
$id = (int)$_POST['id'];

    //Tietokanta DELETE KATEGORIA
    $stmt = $conn->prepare("DELETE FROM kategoriat WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
      $_SESSION["msg"] =["text" => "kategoria poistettiin onnistuneesti", "type" => "success"];
    } else {
        $_SESSION["msg"] =["text" => "kategoriaa ei voitu poistaa", "type" => "error"];
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

//Haku toiminto select
$kategoriat=$conn->query("SELECT * FROM kategoriat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoria</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
    <h1>Esimerkki crud</h1>
    <h2>Lisää uusi kategoria</h2>

<?php if (isset($_SESSION['msg'])): ?>
    <?php
    $msg = $_SESSION['msg'];
    $color = $msg['type'] === "success" ? "#d4edda" : "#f8d7da";
    $textcolor = $msg['type'] === "success" ? "#155724" : "#721c24";
    $border = $msg['type'] === "success" ? "#c3e6cb" : "#f5c6cb";
    ?>
    <div id="notif" style="
         background-color: <?= $color ?>;
         color: <?= $textcolor ?>;
         padding: 10px 15px;
         border: 1px solid <?= $border ?>;
         border-radius: 5px;
         margin-bottom: 15px;
         font-weight: bold;
         ">

         <?= htmlspecialchars($msg['text']) ?>
</div>
<?php unset($_SESSION['msg']); ?>
<script>
    setTimeout(() => {
        const box = document.getElementById("notif");
        if (box) {
            box.style.transition = "opacity 0.5s ease";
            box.style.opacity="0";
            setTimeout(() => box.remove(), 500);
        }
    }, 3000);
   </script>
   <?php endif; ?>

    <form method="post">
    Nimi: <input type="text" name="nimi">
    <button type = "submit" name="add">Lisää</button>

    </form>
    <h1>Nykyiset kategoriat</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nimi</th>
            <th>Toiminnot</th>
</tr>

<?php while($row = $kategoriat->fetch_assoc()){ ?>
    <?php echo $row ['id'];    ?>
    <tr>
        <form method="post">
        <td><?=$row['id'] ?></td>
        <td>
            <input type="text" name="nimi" value="<?=$row['nimi'] ?>">
</td>
<td>
    <input type="hidden" name="id" value="<?=$row['id']?>">
    <button type="submit" name="muokkaa">Muokkaa</button>
    <button type="submit" name="poista">Poista</button>
</td>
</form>

</tr>


<?php }; ?>

</table>
</body>
</html>