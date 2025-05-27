<?php
session_start();
include "conexao.php";

$idTarefa = $_POST['idTarefa'];
$nome = $_POST['nome'];
$desc = $_POST['desc'];
$idColuna = $_POST['coluna_idCol'];

if (empty($idTarefa)) {
    // Inserir nova tarefa
    $pdo->beginTransaction();

    // Insere a tarefa
    $sql = "INSERT INTO tarefa (nomeTarefa, descTarefa) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $desc]);
    $idTarefa = $pdo->lastInsertId();

    // Associa à coluna
    $sql = "INSERT INTO projeto_has_coluna_has_tarefa (projeto_idProj, coluna_idCol, tarefa_idTarefa, estado_tarefa) VALUES (?, ?, ?, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idProj'], $idColuna, $idTarefa]);

    $pdo->commit();
} else {
    $estado = $_POST['estado'];
    // Atualizar tarefa existente
    $sql = "UPDATE tarefa SET nomeTarefa = ?, descTarefa = ? WHERE idTarefa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $desc, $idTarefa]);

    $sql = "UPDATE projeto_has_coluna_has_tarefa SET estado_tarefa = ? WHERE tarefa_idTarefa = ? AND coluna_idCol = ? AND projeto_idProj = " . $_SESSION['idProj'];
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$estado, $idTarefa, $idColuna]);
}

header("Location: prjct_manager.php");
exit();
