<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idFunc = $_POST['idFunc'];
    $nomeFunc = $_POST['nomeFunc'];
    $cargoFunc = $_POST['cargoFunc'];
    $emailLogin = $_POST['emailLogin'];

    try {
        $sql = "UPDATE funcionario f
                JOIN login l ON f.login_idLogin = l.idLogin
                SET f.nomeFunc = ?, f.cargoFunc = ?, l.emailLogin = ?
                WHERE f.idFunc = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nomeFunc, $cargoFunc, $emailLogin, $idFunc]);

        header("Location: admPage.php"); // Redireciona de volta à página principal
    } catch (PDOException $e) {
        echo "Erro ao atualizar funcionário: " . $e->getMessage();
    }
}
?>
