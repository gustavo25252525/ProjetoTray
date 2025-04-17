<?php
include "conexao.php";

$busca = isset($_GET['termo']) ? $_GET['termo'] : '';

if ($busca != '') {
    $sql = "SELECT * FROM projeto WHERE nomeProj LIKE :nome";
    $buscaParam = "%" . $busca . "%";
} else {
    $sql = "SELECT * FROM projeto";
}

$comando = $pdo->prepare($sql);
if (isset($buscaParam)) {
    $comando->bindParam(":nome", $buscaParam);
}
$comando->execute();
$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

// Retornar os resultados como JSON
header('Content-Type: application/json');
echo json_encode($resultado);