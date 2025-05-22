<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Administração - Funcionários e Clientes</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
    .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h1 { text-align: center; margin-bottom: 20px; }
    input[type="text"] { width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc; }
    h2 { margin-top: 30px; }
    ul { list-style: none; padding: 0; }
    li { padding: 8px; border-bottom: 1px solid #eee; }
    .email { color: #777; font-size: 0.9em; }
  </style>
  <script>
    function filtrar(valor) {
      valor = valor.toLowerCase();
      const listas = document.querySelectorAll("ul li");

      listas.forEach(li => {
        const nome = li.querySelector(".nome").textContent.toLowerCase();
        li.style.display = nome.includes(valor) ? "" : "none";
      });
    }
  </script>

</head>
<body>
  <div class="container">
    <h1>Lista de Funcionários e Clientes</h1>

    <input type="text" placeholder="Buscar por nome ou email..." oninput="filtrar(this.value)">

    <div>
      <h2>👷 Funcionários</h2>
      <ul>
        <?php
        $sql = "SELECT f.nomeFunc, f.cargoFunc, l.emailLogin 
                FROM funcionario f
                JOIN login l ON f.login_idLogin = l.idLogin";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
          echo "<li><span class='nome'><strong>{$row['nomeFunc']}</strong></span> - {$row['cargoFunc']}<br><span class='email'>{$row['emailLogin']}</span></li>";
        }
        ?>
      </ul>
    </div>

    <div>
      <h2>🏢 Clientes</h2>
      <ul>
        <?php
        $sql = "SELECT c.nomeCli, c.empresaCli, l.emailLogin 
                FROM cliente c
                JOIN login l ON c.login_idLogin = l.idLogin";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
          echo "<li><span class='nome'><strong>{$row['nomeCli']}</strong></span> - {$row['empresaCli']}<br><span class='email'>{$row['emailLogin']}</span></li>";
        }
        ?>
      </ul>
    </div>
  </div>
</body>
</html>
