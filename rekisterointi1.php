<?php
include "DB1.php";

if (isset($_POST['register'])) {
    $kayttajatunnus = $conn->real_escape_string($_POST['username']);
    $salasana = $_POST['password'];
    $salasana2 = $_POST['password2'];

    if($salasana !== $salasana2) {
        $error = "Salasanat eivät täsmää";
    } else {
        $res = $conn->query("SELECT id FROM kayttajat WHERE kayttajatunnus='$kayttajatunnus'");
        if ($res->num_rows > 0) {
            $error = "Käyttäjätunnus on jo käytössä!";
        } else {
            $hash = password_hash($salasana, PASSWORD_DEFAULT);

            $conn->query("INSERT INTO kayttajat (kayttajatunnus, salasana, rooli) VALUES ('$kayttajatunnus', '$hash', 'asiakas')");

            $success = "Rekisteröinti onnistui, voit nyt <a href='login.php'>kirjautua</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröidy</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
    <h1>Rekisteröidy</h1>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'"; ?>

    <form method="post">
        Käyttäjätunnus: <input type="text" name="username" required><br><br>
        salasana: <input type="password" name="password" name="password" required><br><br>
         salasana uudelleen: <input type="password"  name="password2" required><br><br>
         <button type="submit" name="register">Rekisteröidy</button>
</form>
<p><a href="login.php">Kirjaudu sisään</a></p>


</body>
</html>