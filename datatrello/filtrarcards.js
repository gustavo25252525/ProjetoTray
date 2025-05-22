const fs = require('fs');

// Lê o arquivo JSON original
const rawData = fs.readFileSync('datatrello.json');
const data = JSON.parse(rawData);

// Mapeamento de membros (para facilitar consulta por ID se quiser nomes completos depois)
const memberMap = {};
data.actions.forEach(action => {
  const member = action.member;
  if (member && member.id) {
    memberMap[member.id] = member.fullName;
  }
});

// Objeto para armazenar informações únicas por card
const cardsMap = {};

data.actions.forEach(action => {
  if (
    action.type === 'updateCard' &&
    action.data.card &&
    action.data.card.dueComplete === true
  ) {
    const cardId = action.data.card.id;

    // Se ainda não adicionamos esse card
    if (!cardsMap[cardId]) {
      cardsMap[cardId] = {
        id: cardId,
        nome: action.data.card.name || '',
        dataCriacao: action.date || null,
        dataEntrega: action.data.card.due || null,
        membros: []
      };
    }
  }

  // Pegando membros atribuídos
  if (
    action.type === 'addMemberToCard' &&
    action.data.card &&
    cardsMap[action.data.card.id]
  ) {
    const member = action.data.member;
    if (member && member.fullName && !cardsMap[action.data.card.id].membros.includes(member.fullName)) {
      cardsMap[action.data.card.id].membros.push(member.fullName);
    }
  }
});

// Convertendo para array final
const cardsConcluidos = Object.values(cardsMap);

// Salvando em novo arquivo JSON
fs.writeFileSync('cards-concluidos.json', JSON.stringify(cardsConcluidos, null, 2));

console.log(`Exportado ${cardsConcluidos.length} cards concluídos para 'cards-concluidos.json'.`);
