<?php
session_start();
include "conexao.php";

$dados = json_decode(file_get_contents('php://input'), true);
$idTarefa = $dados['idTarefa'];
$idColuna = $dados['idColuna'];

if ($idTarefa) {
    // Primeiro exclui da tabela de relacionamento
    $sql = "DELETE FROM coluna_has_tarefa WHERE tarefa_idTarefa = ? AND coluna_idCol = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idTarefa, $idColuna]);

    // Depois exclui a tarefa
    $sql = "DELETE FROM tarefa WHERE idTarefa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idTarefa]);

    echo json_encode(['success' => true]);
}
