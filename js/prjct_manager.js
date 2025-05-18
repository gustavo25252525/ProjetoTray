// Dados das fases (pode ser substituído por dados dinâmicos posteriormente)
const fasesData = {
  Alinhamento: { completas: 8, total: 15, atualizacao: "10/05/2025" },
  "Fase I": { completas: 12, total: 25, atualizacao: "08/05/2025" },
  "Fase II": { completas: 5, total: 30, atualizacao: "05/05/2025" },
  "Fase III": { completas: 0, total: 17, atualizacao: "---" },
};

// Configurar pop-up para cada fase
document.querySelectorAll(".fase").forEach((fase) => {
  fase.addEventListener("click", () => {
    const nomeFase = fase.textContent;
    const dados = fasesData[nomeFase];

    // Atualizar o pop-up com os dados da fase
    document.getElementById("nome-fase").textContent = nomeFase;
    document.getElementById("completas").textContent = dados.completas;
    document.getElementById("total").textContent = dados.total;
    document.getElementById("atualizacao").textContent =
      dados.atualizacao;

    // Calcular e atualizar a barra de progresso
    const percentual = (dados.completas / dados.total) * 100;
    document.querySelector(".progresso").style.width = percentual + "%";

    // Atualizar status baseado no progresso
    const statusElement = document.getElementById("status");
    if (percentual === 0) {
      statusElement.textContent = "Não iniciada";
    } else if (percentual === 100) {
      statusElement.textContent = "Completa";
    } else {
      statusElement.textContent = "Em andamento";
    }
  });
});


