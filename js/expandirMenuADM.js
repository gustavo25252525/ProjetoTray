
const menuLateral = document.querySelector('.menu-lateral');
const btnExpandir = document.querySelector('#bnt-exp');
const mainConteudo = document.querySelector('.main-conteudo');

btnExpandir.addEventListener('click', () => {
    menuLateral.classList.toggle('expandir');

    if (menuLateral.classList.contains('expandir')) {
        mainConteudo.style.marginLeft = '250px';
    } else {
        mainConteudo.style.marginLeft = '80px';
    }
});
