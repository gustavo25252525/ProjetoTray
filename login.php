<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT l.emailLogin, l.senhaLogin, f.idFunc, c.idCli, t.nomeTipo 
            FROM login l 
            INNER JOIN funcionario f ON l.idLogin = f.login_idLogin
            INNER JOIN cliente c ON l.idLogin = c.login_idLogin
            INNER JOIN tipo t ON l.tipo_idTipo = t.idTipo 
            WHERE emailLogin = :email";


    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch();

    if ($usuario) {
        if ($senha === $usuario['senhaLogin']) {
            $_SESSION['email'] = $usuario['emailLogin'];
            $_SESSION['tipo'] = $usuario['nomeTipo'];

            if ($usuario['idCli'] == NULL) {
                $_SESSION['usuario_id'] = $usuario['idFunc'];
            } else {
                $_SESSION['usuario_id'] = $usuario['idCli'];
            }
            header("Location: home.php");
            exit;
        }
    }

    echo "Login inválido!";
}
