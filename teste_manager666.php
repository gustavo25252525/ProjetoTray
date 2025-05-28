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
    $sql = "SELECT DISTINCT c.idCol, c.nomeCol
            FROM coluna c 
            INNER JOIN projeto_has_coluna_has_tarefa pct 
                ON c.idCol = pct.coluna_idCol 
            WHERE pct.projeto_idProj = " . $_SESSION["idProj"];
    $comando = $pdo->query($sql);
    $colunas = $comando->fetchAll();

    return $colunas;
}

function puxa_tarefas(PDO $pdo)
{
    $colunas = puxa_colunas($pdo);
    if (empty($colunas)) {
        return [];
    }

    $idsColunas = array_column($colunas, 'idCol');
    $placeholders = implode(',', array_fill(0, count($idsColunas), '?'));

    $sql = "SELECT t.idTarefa, t.nomeTarefa, t.descTarefa, pct.estado_tarefa, pct.coluna_idCol 
            FROM tarefa t 
            INNER JOIN projeto_has_coluna_has_tarefa pct 
                ON t.idTarefa = pct.tarefa_idTarefa 
            WHERE pct.coluna_idCol IN ($placeholders) AND pct.projeto_idProj = " . $_SESSION['idProj'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_sugestao'])) {
    $id_cliente = 1; // Defina corretamente com base no login
    $tarefa = $_POST['tarefa'];
    $mensagem = $_POST['mensagem'];
    $categoria = $_POST['categoria'];

    $stmt = $pdo->prepare("INSERT INTO sugestoes (id_cliente, tarefa, categoria, mensagem) VALUES (?, ?, ?, ?)");
    $stmt = $pdo->prepare("INSERT INTO sugestao (idCliente, tarefa, categoria, mensagem) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_cliente, $tarefa, $categoria, $mensagem]);

}

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

                        <div class="form_group">
                            <select name="estado" id="estadoTarefa" class="form-control">
                                <option value="0">Não iniciada</option>
                                <option value="1">Em andamento</option>
                                <option value="2">Concluída</option>
                            </select>
                        </div>

                        <div id="btn_adiciona_tarefa">
                            <button type="submit" id="enviar_form">Adicionar</button>
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

                <div class="sugestao-container">
            <h3>Sugestões do Cliente</h3>

            <form method="POST" class="sugestao-form">
                <label>Tarefa Selecionada:</label><br>
                <input type="text" name="tarefa" required><br><br>

                <label>Mensagem:</label><br>
                <textarea name="mensagem" rows="4" cols="50" required></textarea><br><br>

                <label>Categoria:</label><br>
                <div class="radio-group">
                    <input type="radio" name="categoria" value="adicionar" required> Adicionar
                    <input type="radio" name="categoria" value="incrementar"> Incrementar
                    <input type="radio" name="categoria" value="remover"> Remover<br><br>
                </div>

                <button type="submit" name="enviar_sugestao">Enviar</button>
            </form>

            <hr>

            <div class="sugestoes-lista">
                <div class="sugestoes-coluna">
                    <h4>Sugestões em Análise</h4>
                    <?php
                    $res = $pdo->query("SELECT tarefa, mensagem, categoria FROM sugestoes WHERE status = 'em_analise'");
                    while ($row = $result->fetch()) {
                        echo "<div style='border:1px solid #ccc; padding:10px; margin:5px 0;'>";
                        echo "<b>Tarefa:</b> " . htmlspecialchars($row['tarefa']) . "<br>";
                        echo "<b>Categoria:</b> " . htmlspecialchars($row['categoria']) . "<br>";
                        echo "<b>Mensagem:</b> " . nl2br(htmlspecialchars($row['message'])) . "<br>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <div class="sugestoes-coluna">
                    <h4>Sugestões com Feedback</h4>
                    <?php
                    $res = $pdo->query("SELECT tarefa, mensagem, resposta_funcionario, feedback FROM sugestoes WHERE status = 'com_feedback'");
                    while ($row = $result->fetch()) {
                        echo "<div style='border:1px solid #ccc; padding:10px; margin:5px 0;'>";
                        echo "<b>Tarefa:</b> " . htmlspecialchars($row['tarefa']) . "<br>";
                        echo "<b>Mensagem:</b> " . nl2br(htmlspecialchars($row['mensagem'])) . "<br>";
                        echo "<b>Resposta:</b> " . nl2br(htmlspecialchars($row['resposta_funcionario'])) . "<br>";
                        echo "<b>Feedback:</b> " . ucfirst($row['feedback']) . "<br>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        
    </main>

    <script src="js/prjct_manager.js"></script>

</body>

</html>