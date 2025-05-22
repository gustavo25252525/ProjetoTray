<?php
include 'db.php';

$sql = "SELECT f.idFunc, f.nomeFunc, f.cargoFunc, l.emailLogin 
        FROM funcionario f
        JOIN login l ON f.login_idLogin = l.idLogin
        ORDER BY f.idFunc DESC";

$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
                <span class='nome'>{$row['nomeFunc']}</span> - {$row['cargoFunc']} - <span class='email'>({$row['emailLogin']})</span>
                <form method='POST' action='delete_funcionario.php' style='display:inline; margin-left:10px;'>
                    <input type='hidden' name='idFunc' value='{$row['idFunc']}'>
                    <input type='submit' value='Deletar' onclick=\"return confirm('Tem certeza que deseja deletar este funcionário?');\">
                </form>
              </li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum funcionário encontrado.";
}

?>