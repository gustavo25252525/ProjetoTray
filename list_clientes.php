<?php
include 'conexao.php';

if (!$conexao) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$tipoId = 2;

// Tratamento do POST para cadastrar novo cliente
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nomeCli'], $_POST['empresaCli'], $_POST['telefoneCli'], $_POST['emailLogin'], $_POST['senhaLogin'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nomeCli']);
    $empresa = mysqli_real_escape_string($conexao, $_POST['empresaCli']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefoneCli']);
    $email = mysqli_real_escape_string($conexao, $_POST['emailLogin']);
    $senha = password_hash($_POST['senhaLogin'], PASSWORD_DEFAULT);

    // Verifica se o email já existe na tabela login para evitar duplicidade
    $checkEmail = "SELECT idLogin FROM login WHERE emailLogin = '$email' LIMIT 1";
    $resCheck = mysqli_query($conexao, $checkEmail);
    if (mysqli_num_rows($resCheck) > 0) {
        echo "<p style='color:red;'>Erro: Email já cadastrado.</p>";
    } else {
        // Inserir na tabela login com tipo_idTipo
        $insertLogin = "INSERT INTO login (emailLogin, senhaLogin, tipo_idTipo) VALUES ('$email', '$senha', $tipoId)";
        if (mysqli_query($conexao, $insertLogin)) {
            $idLogin = mysqli_insert_id($conexao);

            // Inserir na tabela cliente
            $insertCli = "INSERT INTO cliente (nomeCli, empresaCli, telefoneCli, login_idLogin) VALUES ('$nome', '$empresa', '$telefone', $idLogin)";
            if (!mysqli_query($conexao, $insertCli)) {
                echo "<p style='color:red;'>Erro ao cadastrar cliente: " . mysqli_error($conexao) . "</p>";
            } else {
                // Redireciona para evitar reenvio do formulário
                echo "<p style='color:green;'>Cliente cadastrado com sucesso.</p>";
            }
        } else {
            echo "<p style='color:red;'>Erro ao cadastrar login: " . mysqli_error($conexao) . "</p>";
        }
    }
}

// Listagem de Clientes
$sql = "SELECT c.idCli, c.nomeCli, c.empresaCli, c.telefoneCli, l.emailLogin 
        FROM cliente c
        JOIN login l ON c.login_idLogin = l.idLogin
        ORDER BY c.idCli DESC";

$result = mysqli_query($conexao, $sql);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

// Título com botão "Novo Cliente"
echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2 style="margin: 0;">Lista de Clientes</h2>
        <button onclick="document.getElementById(\'modal-novo-cliente\').style.display=\'block\'" 
                style="padding: 4px 10px; font-size: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
            + Novo Cliente
        </button>
      </div>';

// Listagem de clientes
if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['idCli'];
        $nome = addslashes($row['nomeCli']);
        $empresa = addslashes($row['empresaCli']);
        $telefone = addslashes($row['telefoneCli']);
        $email = addslashes($row['emailLogin']);

        echo "<li>
                <span class='nome'>{$nome}</span> - {$empresa} - {$telefone} - <span class='email'>({$email})</span>
                <button onclick=\"abrirModalCliente({$id}, '{$nome}', '{$empresa}', '{$telefone}', '{$email}')\">Editar</button>
              </li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum cliente encontrado.";
}
?>

<!-- Modal de Cadastro de Novo Cliente -->
<div id="modal-novo-cliente" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border:1px solid #ccc; z-index:1000;">
    <h3>Novo Cliente</h3>
    <form method="POST" action="">
        <label>Nome:</label><br>
        <input type="text" name="nomeCli" required><br>
        <label>Empresa:</label><br>
        <input type="text" name="empresaCli" required><br>
        <label>Telefone:</label><br>
        <input type="text" name="telefoneCli" required><br>
        <label>Email:</label><br>
        <input type="email" name="emailLogin" required><br>
        <label>Senha:</label><br>
        <input type="password" name="senhaLogin" required><br><br>
        <button type="submit">Salvar</button>
        <button type="button" onclick="document.getElementById('modal-novo-cliente').style.display='none'">Cancelar</button>
    </form>
</div>

<!-- Modal de Edição de Cliente -->
<div id="modal-cliente" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border:1px solid #ccc; z-index:1000;">
    <h3>Editar Cliente</h3>
    <form method="POST" action="editar_cliente.php" style="margin-bottom: 10px;">
        <input type="hidden" name="idCli" id="edit-idCli">
        <label>Nome:</label><br>
        <input type="text" name="nomeCli" id="edit-nomeCli" required><br>
        <label>Empresa:</label><br>
        <input type="text" name="empresaCli" id="edit-empresaCli" required><br>
        <label>Telefone:</label><br>
        <input type="text" name="telefoneCli" id="edit-telefoneCli" required><br>
        <label>Email:</label><br>
        <input type="email" name="emailLogin" id="edit-emailCli" required><br><br>
        <button type="submit">Salvar</button>
    </form>

    <!-- Botão de Deletar -->
    <form method="POST" action="deletar_cliente.php" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
        <input type="hidden" name="idCli" id="delete-idCli">
        <button type="submit" style="background-color:red; color:white;">Deletar</button>
        <button type="button" onclick="fecharModalCliente()">Cancelar</button>
    </form>
</div>

<script>
    function abrirModalCliente(id, nome, empresa, telefone, email) {
        document.getElementById('edit-idCli').value = id;
        document.getElementById('edit-nomeCli').value = nome;
        document.getElementById('edit-empresaCli').value = empresa;
        document.getElementById('edit-telefoneCli').value = telefone;
        document.getElementById('edit-emailCli').value = email;
        document.getElementById('delete-idCli').value = id;
        document.getElementById('modal-cliente').style.display = 'block';
    }

    function fecharModalCliente() {
        document.getElementById('modal-cliente').style.display = 'none';
    }
</script>
