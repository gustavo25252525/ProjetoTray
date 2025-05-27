<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCli = $_POST['idCli'];
    $nomeCli = $_POST['nomeCli'];
    $empresaCli = $_POST['empresaCli'];
    $emailLogin = $_POST['emailLogin'];

    try {
        // Atualizar cliente
        $sql = "UPDATE cliente c
                JOIN login l ON c.login_idLogin = l.idLogin
                SET c.nomeCli = ?, c.empresaCli = ?, l.emailLogin = ?
                WHERE c.idCli = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nomeCli, $empresaCli, $emailLogin, $idCli]);

        header("Location: admPage.php"); 
    } catch (PDOException $e) {
        echo "Erro ao atualizar cliente: " . $e->getMessage();
    }
}
?>
