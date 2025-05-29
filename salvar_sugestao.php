<?php

$id_cliente = $_SESSION['usuario_id'];
$tarefa = $_POST['tarefa'];
$mensagem = $_POST['mensagem'];
$categoria = $_POST['categoria'];

$comando = $pdo->prepare("INSERT INTO sugestoes (id_cliente, tarefa, categoria, mensagem) VALUES (?, ?, ?, ?)");
$comando->execute([$id_cliente, $tarefa, $categoria, $mensagem]);

header("Location: prjct_manager.php");
exit();