<?php
include 'db.php';

$sql = "SELECT f.nomeFunc, f.cargoFunc, l.emailLogin 
        FROM funcionario f
        JOIN login l ON f.login_idLogin = l.idLogin";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li><span class='nome'>{$row['nomeFunc']}</span> - {$row['cargoFunc']} - <span class='email'>({$row['emailLogin']})</span></li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum funcionário encontrado.";
}
?>