<?php
include "conexao.php";

$nome = $_POST['nomeFunc'];
$cargo = $_POST['cargoFunc'];
$email = $_POST['emailLogin'];
$senha = $_POST['senhaLogin'];

// Verifica se o email já existe na tabela login para evitar duplicidade
$sql_checa_email = "SELECT idLogin FROM login WHERE emailLogin = ?";
$comando = $pdo->prepare($sql_checa_email);
$comando->execute([$email]);
$email_checado = $comando->fetchAll();

if (count($email_checado) > 0) {
    echo "<p style='color:red;'>Erro: Email já cadastrado.</p>";
} else {
    // Inserir na tabela login com tipo_idTipo
    $sql_cria_login = "INSERT INTO login (emailLogin, senhaLogin, tipo_idTipo) VALUES (?, ?, 1)";
    $comando = $pdo->prepare($sql_cria_login);
    $comando->execute([$email, $senha]);

    $idLogin = $pdo->lastInsertId();

    // Inserir na tabela funcionario
    $sql_cria_funcionario = "INSERT INTO funcionario (nomeFunc, cargoFunc, login_idLogin) VALUES (?, ?, ?)";
    $comando = $pdo->prepare($sql_cria_funcionario);
    $comando->execute([$nome, $cargo, $idLogin]);
}

header("Location: admPage.php");
exit();
