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
});
