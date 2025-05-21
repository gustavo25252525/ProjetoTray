<<<<<<< Updated upstream
// Ativa destaque visual do menu
const menuItem = document.querySelectorAll('.item-menu');
menuItem.forEach((item) =>
  item.addEventListener('click', function () {
    menuItem.forEach((el) => el.classList.remove('ativos'));
    this.classList.add('ativos');
  })
);

// Referência às divs de conteúdo
const homeContent = document.getElementById('homeContent');
const clienteContent = document.getElementById('clienteContent');
const funcionarioContent = document.getElementById('funcionarioContent');

// Função para esconder todas
function esconderTodosConteudos() {
  homeContent.style.display = 'none';
  clienteContent.style.display = 'none';
  funcionarioContent.style.display = 'none';
}

// Eventos dos links
document.getElementById('homeLink').addEventListener('click', function (e) {
  e.preventDefault();
  esconderTodosConteudos();
  homeContent.style.display = 'block';
});

document.getElementById('clienteLink').addEventListener('click', function (e) {
  e.preventDefault();
  esconderTodosConteudos();
  clienteContent.style.display = 'block';
});

document.getElementById('funcionarioLink').addEventListener('click', function (e) {
  e.preventDefault();
  esconderTodosConteudos();
  funcionarioContent.style.display = 'block';
=======
var menuItem = document.querySelectorAll('.item-menu');

function selecionarLink(){
    menuItem.forEach((item) =>
        item.classList.remove('ativos'));
    this.classList.add('ativos');
}

menuItem.forEach((item) => item.addEventListener('click', selecionarLink));

document.getElementById('homeLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('homeContent').style.display = 'block';
    document.getElementById('funcionarioContent').style.display = 'none';
    document.getElementById('clienteContent').style.display = 'none';
});

document.getElementById('funcionarioLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('homeContent').style.display = 'none';
    document.getElementById('clienteContent').style.display = 'none';
    document.getElementById('funcionarioContent').style.display = 'block';
});

document.getElementById('clienteLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('homeContent').style.display = 'none';
    document.getElementById('funcionarioContent').style.display = 'none';
    document.getElementById('clienteContent').style.display = 'block';
>>>>>>> Stashed changes
});
