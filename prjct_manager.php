<?php
session_start();

if (!isset($_SESSION["idProj"])) {
    header("Location: login.php");
}

function info_proj(PDO $pdo)
{
    $sql = "SELECT nomeProj, descProj FROM projeto WHERE idProj = " . $_SESSION["idProj"];
    $comando = $pdo->query($sql);
    $projeto = $comando->fetch();

    return $projeto;
}

function puxa_colunas(PDO $pdo)
{
    $sql = "SELECT c.idCol, c.nomeCol
            FROM coluna c 
            INNER JOIN projeto_has_coluna pc 
                ON c.idCol = pc.coluna_idCol 
            WHERE pc.projeto_idProj = " . $_SESSION["idProj"];
    $comando = $pdo->query($sql);
    $colunas = $comando->fetchAll();

    return $colunas;
}

function puxa_tarefas(PDO $pdo) {
    $colunas = puxa_colunas($pdo);
    if (empty($colunas)) {
        return [];
    }

    $idsColunas = array_column($colunas, 'idCol');
    $placeholders = implode(',', array_fill(0, count($idsColunas), '?'));

    $sql = "SELECT t.idTarefa, t.nomeTarefa, t.descTarefa, ct.estado_tarefa, ct.coluna_idCol 
            FROM tarefa t 
            INNER JOIN coluna_has_tarefa ct 
                ON t.idTarefa = ct.tarefa_idTarefa 
            WHERE ct.coluna_idCol IN ($placeholders)";

    $comando = $pdo->prepare($sql);
    $comando->execute($idsColunas);
    return $comando->fetchAll();
}

function puxa_notificacoes(PDO $pdo)
{
    $sql = "SELECT * FROM notificacao";
    $comando = $pdo->query($sql);
    $notificacoes = $comando->fetchAll();

    return $notificacoes;
}


include "conexao.php";

$projeto = info_proj($pdo);
$lista_colunas = puxa_colunas($pdo);
$lista_tarefas = puxa_tarefas($pdo);
$lista_notificacoes = puxa_notificacoes($pdo);

$colunas_json = json_encode($lista_colunas);
$tarefas_json = json_encode($lista_tarefas);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/prjct_manager.css">
    <title>Gerenciador</title>
    <script>
        const colunasData = <?= $colunas_json ?>;
        const tarefasData = <?= $tarefas_json ?>;
    </script>
</head>

<body>
    <!--Cabeçalho com logo, usuário e sino de notificações-->
    <header id="cabecalho">
        <img id="logo" src="assets/logo.png" alt="logo da Tray">

        <h1><?= $projeto["nomeProj"] ?></h1>
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
                    <?php foreach ($lista_colunas as $coluna) { ?>
                        <div class="fase" data-id="<?= $coluna['idCol'] ?>"><?= $coluna["nomeCol"] ?></div>
                    <?php } ?>
                </div>
            </div>

            <div id="detalhes_e_form">
                <div class="detalhes_fase">
                    <h2 id="nome-fase"></h2>

                    <div class="barra-progresso">
                        <div class="progresso"></div>
                    </div>

                    <p>Tarefas completas: <span id="completas"></span>/<span id="total"></span></p>
                    <p>Status: <span id="status"></span></p>
                    <p>Última atualização: <span id="atualizacao">Hoje</span></p> <!-- Fixo por enquanto -->
                </div>

                <div class="adicionar_tarefa">
                    <h2>Adicionar tarefa</h2>

                    <form action="salvar_tarefa.php" id="form_tarefa" method="POST">
                        <input type="hidden" name="idTarefa" id="idTarefa" value="">
                        <input type="hidden" name="coluna_idCol" id="coluna_idCol" value="">

                        <div class="form_group">
                            <input type="text" name="nome" id="nomeTarefa" placeholder="Nome" required>
                        </div>

                        <div class="form_group">
                            <input type="text" name="desc" id="descTarefa" placeholder="Descrição">
                        </div>

                        <div id="btn_adiciona_tarefa">
                            <button type="submit">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>


            <div id="lista_tarefas">
                <h2>Tarefas</h2>

                <div id="tarefas">
                    <?php foreach ($lista_tarefas as $tarefa) { ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <script src="js/prjct_manager.js"></script>
</body>

</html>