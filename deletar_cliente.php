<?php
include 'db.php'; 
$conexao = mysqli_connect("localhost", "root", "", "ProjetoTray");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCli'])) {
    $idCli = intval($_POST['idCli']);

    
    $sql = "SELECT login_idLogin FROM cliente WHERE idCli = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idCli);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idLogin);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($idLogin) {
        // Deletar o cliente
        $sql = "DELETE FROM cliente WHERE idCli = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idCli);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Deletar o login associado
        $sql = "DELETE FROM login WHERE idLogin = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idLogin);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redireciona para a página principal 
        header("Location: admPage.php");
        exit();
    } else {
        echo "Cliente não encontrado.";
    }
} else {
    echo "Requisição inválida.";
}
?>
