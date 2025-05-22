<?php
include 'db.php';

$sql = "SELECT c.nomeCli, c.empresaCli, l.emailLogin 
        FROM cliente c
        JOIN login l ON c.login_idLogin = l.idLogin";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li><span class='nome'>{$row['nomeCli']}</span> - {$row['empresaCli']} - <span class='email'>({$row['emailLogin']})</span></li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum cliente encontrado.";
}
?>