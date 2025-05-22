<?php
$host = "localhost";
$user = "root"; // ou o usuário que você usa
$pass = "0805";     // senha do seu MySQL
$dbname = "projetotray";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}
?>
