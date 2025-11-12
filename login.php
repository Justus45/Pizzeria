<?php
include "DB1.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

if (isset($_POST['login'])) {
    $kayttajatunnus = $conn->real_escape_string($_POST['username']);
    $salasana = $_POST['password'];

    $res = $conn->query("SELECT * FROM kayttajat WHERE kayttajatunnus='$kayttajatunnus'");
    if ($res->num_rows == 1) {
        $kayttaja = $res->fetch_assoc();

        if (password_verify($salasana, $kayttaja['salasana'])) {
            $_SESSION['kayttaja'] = $kayttaja;
            header("Location: index.php");
            exit;
        }else {
            $error = "väärä salasana";
        }
    }else {
        $error = "käyttäjää ei löytynyt!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kirjaudu</title>
    <link rel="stylesheet" href="tyylipizza.css">
</head>
<body>
<h1>Kirjaudu</h1>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <label>Käyttäjätunnus: <input type="text" name="username" required></label><br>
    <label>Salasana: <input type="password" name="password" required></label><br>
    <button type="submit" name="login">Kirjaudu</button>
</form>
<p><a href="rekisterointi1.php">Rekisteröidy</a></p>
 <p><a href="index.php">Takaisin kauppaan</a></p>
</body>
</html>
