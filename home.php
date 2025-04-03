<?php
include "conexao.php";

$sql = "select * from projetos";    // String com o comando SQL a ser executado
// $comando = $pdo->query($sql);       // Montamos e deixamos o comando SQL preparado
// $resultado = $comando->fetchAll();  // Executamos o comando $sql, nesse caso, todo o conteudo da tabela produto

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="estilos/home.css">
</head>

<body>
    <!-- Cabeçalho com logomarca da Tray -->
    <header id="cabecalho">
        <img id="logo" src="assets/logo.png" alt="logo da Tray">

        <!-- "Barra" onde fica o indicador de usuário e o sino de notificações -->
        <div id="barraUser">
            <div id="user">
                <img id="userImg" src="assets/user.png" alt="Imagem de usuário">
                <p>(Nome do usuário)</p>
            </div>
            <a id="sino" href=""><img id="sinoImg" src="assets/sino.png" alt="sino de notificações"></a>
        </div>
    </header>

    <main>
        <!-- Barra de criação de projeto -->
        <div id="containerCriaProjeto">
            <div id="criarProjeto">
                <h1>Criar Projeto</h1>
                <a id="criar">
                    <p>+</p>
                </a>
            </div>
        </div>

        <!-- Local onde ficam os projetos já existentes -->
        <div id="containerProjetos">
            <div id="projetos">
                <div id="cabecalhoProjetos">
                    <h1>Projetos</h1>
                    <div>
                        <input type="text" name="busca" id="busca" placeholder="Buscar">
                    </div>
                </div>

                <div id="listaProjetos">
                    <div class="degradeFundo">
                        <div class="infoProjeto">
                            <h2>Projeto 1</h2>
                            <div class="barra">
                                <div class="progressoBarra"></div>
                            </div>
                            <div class="maisInfoProjeto">
                                <a class="maisLink" href="">...</a> <!-- editar nome, descrição e prazo, excluir projeto ou marcar como concluído -->
                            </div>
                        </div>
                    </div>
                    <div class="degradeFundo">
                        <div class="infoProjeto">
                            <h2>Projeto 2</h2>
                            <div class="barra">
                                <div class="progressoBarra"></div>
                            </div>
                            <div class="maisInfoProjeto">
                                <a class="maisLink" href="">...</a>
                            </div>
                        </div>
                    </div>

                    <!-- Código em PHP que vai fazer as inclusões dos produtos quando o banco estiver pronto -->
                    <?php /* foreach ($resultado as $projeto) { 
                        <div class="degradeFundo">
                            <div class="infoProjeto">
                                <h2><?= $projeto["nome"] ?></h2>
                                <p><?= $projeto["descricao"] ?></p>
                                <p><?= $projeto["prazo"] ?></p>
                                <a id="maisInfoProjeto">...</a> // editar nome, descrição e prazo, excluir projeto ou marcar como concluído 
                            </div>
                        </div>
                    } */ ?>

                </div>
            </div>
        </div>
    </main>

    <div id="meuModal">
        <div id="criandoProjeto">
            <span id="fecharModal">&times;</span>
            <h1>Criar Novo Projeto</h1>
            <div id="containerForm">
                <form action="" id="formCriaProjeto">
                    <div class="campoForm">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" required id="inputNomeProjeto">
                    </div>

                    <div class="campoForm">
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" required id="inputDescProjeto">
                    </div>

                    <div id="btn">
                        <button id="btnCriar">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/home.js"></script>
</body>

</html>