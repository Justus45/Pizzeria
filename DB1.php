<?php
$host = "localhost";
$user = "213583";
$password = "enkA2I2xkffL1kTq";
$dbname ="213583" ;
$conn = new mysqli($host, $user, $password, $dbname  );

if($conn->connect_error) {
    die("Yhteys epäonnistui:" . $conn->connect_error);
}
$conn->set_charset("utf8");
?>