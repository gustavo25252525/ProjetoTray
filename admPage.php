<?php 

$conexao = mysqli_connect("localhost", "root", "", "ProjetoTray");

$sql1 = "SELECT * FROM cliente ORDER BY idCli DESC";
$result = mysqli_query($conexao, $sql1);

$sql2 = "SELECT * FROM funcionario ORDER BY idFunc DESC";
$result1 = mysqli_query($conexao, $sql2);
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleADM.css">

</head>

<body>
    <img src="assets/logotray.png" class="logo" alt="Logo">
    <nav class="menu-lateral">
        <div class="btn-expandir">
            <i class="bi bi-list" id="bnt-exp"></i>
        </div>
        <script src="js/expandirMenuADM.js"></script>
        <ul>
            <li class="item-menu">
                <a href="#" id="homeLink">
                    <span class="icon"><i class="bi bi-house"></i></span>
                    <span class="txt-link" id="homeLink">Home</span>
                </a>

            </li>
            <li class="item-menu">
                <a href="#" id="funcionarioLink">
                    <span class="icon"><i class="bi bi-person-badge"></i></span>
                    <span class="txt-link">Funcionário</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="#" id="clienteLink">
                    <span class="icon"><i class="bi bi-person-fill"></i></span>
                    <span class="txt-link">Cliente</span>
                </a>

            </li>
        </ul>
    </nav>
    <div class="Home1" id="homeContent" style="display: none;"><strong>Bem Vindo à Área do Administrador</strong><br> <br>
        📋Aqui, você tem acesso às informações essenciais dos funcionários e clientes cadastrados.<br>
        De forma prática, é possível consultar e editar dados como: <br>
        Visualizar os dados individuais de cada funcionário; <br>
        Editar informações cadastrais como nome, email e senha; <br>
        Gerenciar os projetos vinculados a cada colaborador.
    </div>

    <!-- Tabela de Cliente -->
    <div class="ClienteTable" id="clienteContent" style="display: none;">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome Cliente</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Telefone</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($user_data = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>";
                        echo "<td>".$user_data['idCli']."</td>";
                        echo "<td>".$user_data['nomeCli']."</td>";
                        echo "<td>".$user_data['empresaCli']."</td>";
                        echo "<td>".$user_data['telefoneCli']."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>


    <!-- Tabela de Funcionario -->
    <div class="FuncionarioTable" id="funcionarioContent" style="display: none;">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome Funcionario</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Login</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($user_data = mysqli_fetch_assoc($result1))
                    {
                        echo "<tr>";
                        echo "<td>".$user_data['idFunc']."</td>";
                        echo "<td>".$user_data['nomeFunc']."</td>";
                        echo "<td>".$user_data['cargoFunc']."</td>";
                        echo "<td>".$user_data['login_idLogin']."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>



    
    <script src="js/menuADM.js"></script>
</body>

</html>