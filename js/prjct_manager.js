document.addEventListener('DOMContentLoaded', () => {
  preparandoFases()

  // Seleciona a primeira fase automaticamente
  const primeiraFase = document.querySelector('.fase');
  if (primeiraFase) {
    primeiraFase.click();
  }
});

function preparandoFases() {
  document.querySelectorAll('.fase').forEach(fase => {
    fase.addEventListener('click', function () {
      document.querySelectorAll('.fase').forEach(f => f.classList.remove('selecionada'));
      this.classList.add('selecionada');

      const idColuna = parseInt(this.dataset.id);

      document.getElementById('coluna_idCol').value = idColuna;
      atualizarDetalhesFase(idColuna);
      listarTarefasDaColuna(idColuna);
    });
  });
}



// Função para atualizar os detalhes
function atualizarDetalhesFase(idColuna) {
  const nomeFase = document.getElementById('nome-fase');
  const tarefasCompletas = document.getElementById('completas');
  const totalTarefas = document.getElementById('total');
  const statusColuna = document.getElementById('status');
  const barraProgresso = document.querySelector('.progresso');

  // Encontra a coluna selecionada
  const colunaSelecionada = colunasData.find(col => col.idCol === idColuna);

  if (!colunaSelecionada) return;

  // Atualiza o nome da fase
  nomeFase.textContent = colunaSelecionada.nomeCol;

  // Filtra tarefas desta coluna
  const tarefasDaFase = tarefasData.filter(tarefa => tarefa.coluna_idCol === idColuna);
  const totalTarefasDaFase = tarefasDaFase.length;
  const tarefasConcluidas = tarefasDaFase.filter(t => t.estado_tarefa === 2).length;

  // Atualiza os números
  tarefasCompletas.textContent = tarefasConcluidas;
  totalTarefas.textContent = totalTarefasDaFase;

  // Atualiza a barra de progresso
  const percentual = totalTarefasDaFase > 0 ? Math.round((tarefasConcluidas / totalTarefasDaFase) * 100) : 0;
  barraProgresso.style.width = `${percentual}%`;

  // Atualiza o status
  if (percentual === 100) {
    statusColuna.textContent = 'Concluído';
    statusColuna.style.color = '#4CAF50';
  } else if (percentual > 0) {
    statusColuna.textContent = 'Em andamento';
    statusColuna.style.color = '#2196F3';
  } else {
    statusColuna.textContent = 'Não iniciado';
    statusColuna.style.color = '#9E9E9E';
  }
}

// Função para listar tarefas da coluna específica
function listarTarefasDaColuna(idColuna) {
  const containerTarefas = document.getElementById('tarefas');
  const tarefasDaColuna = tarefasData.filter(tarefa => tarefa.coluna_idCol === idColuna);
  containerTarefas.innerHTML = '';

  if (tarefasDaColuna.length === 0) {
    containerTarefas.innerHTML = '<p class="sem-tarefas">Nenhuma tarefa nesta fase.</p>';
    return;
  }

  tarefasDaColuna.forEach(tarefa => {
    const tarefaElement = document.createElement('div');
    tarefaElement.className = `tarefa-item estado-${tarefa.estado_tarefa}`;
    tarefaElement.dataset.id = tarefa.idTarefa; // Adicione isso se suas tarefas tiverem ID
    tarefaElement.innerHTML = `
            <div class="tarefa-conteudo">
                <div>
                    <h3>${tarefa.nomeTarefa}</h3>
                    <p>${tarefa.descTarefa || 'Sem descrição'}</p>
                </div>
                <div class="tarefa-acoes">
                    <button class="btn-editar" data-id="${tarefa.idTarefa}">
                        Editar
                    </button>
                    <button class="btn-excluir" data-id="${tarefa.idTarefa}">
                        Excluir
                    </button>
                </div>
            </div>
            <div class="tarefa-status">
                <span class="status-badge">${getStatusText(tarefa.estado_tarefa)}</span>
            </div>
        `;
    containerTarefas.appendChild(tarefaElement);
  });

  // Adiciona eventos aos botões
  document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const idTarefa = parseInt(btn.dataset.id);
      editarTarefa(idTarefa);
    });
  });

  document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const idTarefa = parseInt(btn.dataset.id);
      if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
        excluirTarefa(idTarefa, idColuna);
      }
    });
  });
}

function editarTarefa(idTarefa) {
  const tarefa = tarefasData.find(t => t.idTarefa === idTarefa);
  if (!tarefa) return;

  // Preenche o formulário
  document.getElementById('nomeTarefa').value = tarefa.nomeTarefa;
  document.getElementById('descTarefa').value = tarefa.descTarefa;
  document.getElementById('idTarefa').value = idTarefa;
  document.getElementById('coluna_idCol').value = tarefa.coluna_idCol;

  // Altera o botão
  const submitBtn = document.querySelector('#btn_adiciona_tarefa button');
  submitBtn.textContent = 'Atualizar';
}
async function excluirTarefa(idTarefa, idColuna) {
  const response = await fetch('excluir_tarefa.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ idTarefa, idColuna })
  });

  // Recarrega as tarefas
  const faseAtiva = document.querySelector('.fase.selecionada');
  if (faseAtiva) {
    const idColunaAtiva = parseInt(faseAtiva.dataset.id);
    listarTarefasDaColuna(idColunaAtiva);
  }
}

function getStatusText(estado) {
  switch (estado) {
    case 0: return 'Não iniciada';
    case 1: return 'Em andamento';
    case 2: return 'Concluída';
    default: return 'Desconhecido';
  }
}