<?php
session_start();
include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProjeto = intval($_POST['idProjeto']);
    $nomeFase = trim($_POST['nomeFase']);
    $nomeTarefa = trim($_POST['nomeTarefa']);
    $descTarefa = trim($_POST['descTarefa']);

    if (empty($nomeFase) || empty($nomeTarefa)) {
        die('Nome da fase e da tarefa são obrigatórios.');
    }

    try {
        $pdo->beginTransaction();

        // 1. Inserir nova fase na tabela coluna
        $stmt = $pdo->prepare("INSERT INTO coluna (nomeCol) VALUES (:nomeFase)");
        $stmt->execute([':nomeFase' => $nomeFase]);
        $idColuna = $pdo->lastInsertId();

        // 2. Inserir a primeira tarefa na tabela tarefa
        $stmt = $pdo->prepare("INSERT INTO tarefa (nomeTarefa, descTarefa) VALUES (:nomeTarefa, :descTarefa)");
        $stmt->execute([
            ':nomeTarefa' => $nomeTarefa,
            ':descTarefa' => $descTarefa ?: null
        ]);
        $idTarefa = $pdo->lastInsertId();

        // 3. Relacionar projeto, coluna e tarefa na tabela projeto_has_coluna_has_tarefa
        $stmt = $pdo->prepare("
            INSERT INTO projeto_has_coluna_has_tarefa (projeto_idProj, coluna_idCol, tarefa_idTarefa, estado_tarefa)
            VALUES (:idProjeto, :idColuna, :idTarefa, 0)
        ");
        $stmt->execute([
            ':idProjeto' => $idProjeto,
            ':idColuna' => $idColuna,
            ':idTarefa' => $idTarefa
        ]);

        $pdo->commit();

        header("Location: prjct_manager.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erro ao adicionar fase e tarefa: " . $e->getMessage();
    }
} else {
    echo "Método inválido.";
}
?>

