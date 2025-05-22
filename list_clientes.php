<?php
include 'db.php';

$sql = "SELECT c.idCli, c.nomeCli, c.empresaCli, l.emailLogin 
        FROM cliente c
        JOIN login l ON c.login_idLogin = l.idLogin";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<span class='nome'>{$row['nomeCli']}</span> - {$row['empresaCli']} - <span class='email'>({$row['emailLogin']})</span>";

        // Formulário botão deletar
        echo "<form method='POST' action='deletar_cliente.php' style='display:inline-block; margin-left:10px;' onsubmit=\"return confirm('Tem certeza que deseja deletar {$row['nomeCli']}?');\">";
        echo "<input type='hidden' name='idCli' value='{$row['idCli']}'>";
        echo "<button type='submit'>Deletar</button>";
        echo "</form>";

        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum cliente encontrado.";
}
?>