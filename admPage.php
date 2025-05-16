<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM page</title>
    <link rel="stylesheet" href="styles/styleADM.css">.
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <img src="src/logotray.png" class="logo" alt="Logo">
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

    <script src="js/menuADM.js"></script>
</body>

</html>