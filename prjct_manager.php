<?php
session_start();

include "conexao.php";

$sql = "select * from projeto where idProj = " . $_SESSION["idProj"];
$comando = $pdo->query($sql);
$resultado = $comando->fetch();

$sql2 = "select * from notificacao";
$comando2 = $pdo->query($sql2);
$notificacoes = $comando2->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/prjct_manager.css">
    <title>Gerenciador</title>
</head>

<body>
    <!--Cabeçalho com logo, usuário e sino de notificações-->
    <header id="cabecalho">
        <img id="logo" src="assets/logo.png" alt="logo da Tray">

        <h1><?= $resultado["nomeProj"] ?></h1>
        <!-- "Barra" onde fica o indicador de usuário e o sino de notificações -->
        <div id="icones">
            <img id="userImg" src="assets/user.png" alt="Imagem de usuário">
            <a id="sino" href="#"><img src="assets/sino.png" alt="sino de notificações"></a>
            <!-- Quando quer que o a leve a lugar nenhum, deixa um # no href -->
        </div>
    </header>

    <main>
        <div class="main">
            <!-- Linha do tempo do projeto -->
            <div class="timeline">
                <h2>Desenvolvimento</h2>
                <div class="etapas">
                    <div class="fase">Alinhamento</div>
                    <div class="fase">Fase I</div>
                    <div class="fase">Fase II</div>
                    <div class="fase">Fase III</div>
                </div>
            </div>

            <div class="detalhes_fase">
                <h2 id="nome-fase">Nome da Fase</h2>

                <div class="barra-progresso">
                    <div class="progresso"></div>
                </div>

                <p>Tarefas completas: <span id="completas">0</span>/<span id="total">0</span></p>
                <p>Status: <span id="status">Em andamento</span></p>
                <p>Última atualização: <span id="atualizacao">Hoje</span></p>
            </div>

            <div class="tarefas">
                
            </div>
        </div>
    </main>

    <script src="js/prjct_manager.js"></script>
</body>

</html>