<?php
include 'conexao.php';
$conexao = mysqli_connect("localhost", "root", "", "ProjetoTray");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idFunc'])) {
    $idFunc = intval($_POST['idFunc']);

    // Obter o idLogin associado ao funcionário
    $sql = "SELECT login_idLogin FROM funcionario WHERE idFunc = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idFunc);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idLogin);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($idLogin) {
        // Exclua o funcionário
        $sql = "DELETE FROM funcionario WHERE idFunc = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idFunc);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Exclua o login associado
        $sql = "DELETE FROM login WHERE idLogin = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idLogin);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirecione de volta para a página principal
        header("Location: admPage.php");
        exit();
    } else {
        echo "Funcionário não encontrado.";
    }
} else {
    echo "Requisição inválida.";
}
?>
