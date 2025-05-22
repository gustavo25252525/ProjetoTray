<?php
session_start();
include "conexao.php";

$idTarefa = $_POST['idTarefa'];
$nome = $_POST['nome'];
$desc = $_POST['desc'];
$coluna_idCol = $_POST['coluna_idCol'];

if (empty($idTarefa)) {
    // Inserir nova tarefa
    $pdo->beginTransaction();

    // Insere a tarefa
    $sql = "INSERT INTO tarefa (nomeTarefa, descTarefa) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $desc]);
    $idTarefa = $pdo->lastInsertId();

    // Associa à coluna
    $sql = "INSERT INTO coluna_has_tarefa (coluna_idCol, tarefa_idTarefa, estado_tarefa) VALUES (?, ?, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$coluna_idCol, $idTarefa]);

    $pdo->commit();
} else {
    // Atualizar tarefa existente
    $sql = "UPDATE tarefa SET nomeTarefa = ?, descTarefa = ? WHERE idTarefa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $desc, $idTarefa]);
}

header("Location: prjct_manager.php");
exit();
