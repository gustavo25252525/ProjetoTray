let aux = 0;

/* Função que faz o sino alterar quando clicado */
document.getElementById('sino').addEventListener('click', (event) => {
    /* Evita que a página atualize */
    event.preventDefault();

    const link = document.getElementById('sino');
    link.innerHTML = '';

    const img = document.createElement('img');

    if (aux == 0) {
        img.src = 'assets/sino-selecionado.png';
        img.alt = 'Sino de notificações selecionado';
        aux = 1;
    } else {
        img.src = 'assets/sino.png';
        img.alt = 'Sino de notificações';
        aux = 0;
    }

    img.id = 'sinoImg';

    link.append(img);
});

const modalCriarProjeto = document.getElementById("modalCriarProjeto");
const abrirCriarProjeto = document.getElementById("criar");
const fecharCriarProjeto = document.getElementById("fecharCriarProjeto");

// Abre o modal
abrirCriarProjeto.onclick = () => {
    modalCriarProjeto.classList.add("show");
}

// Fecha o modal
fecharCriarProjeto.onclick = () => {
    modalCriarProjeto.classList.remove("show");
}

// Fecha o modal ao clicar fora do conteúdo
window.onclick = (event) => {
    if (event.target == modalCriarProjeto) {
        modalCriarProjeto.classList.remove("show");
    }
}

const modalNotificacoes = document.getElementById("modalNotificacoes");
const abrirNotificacoes = document.getElementById("sino");
let auxNotificacoes = 0

function posicionarModal() {
    // Calcula a posição do botão
    const rect = abrirNotificacoes.getBoundingClientRect();
    // Define a posição do modal
    modalNotificacoes.style.top = `${rect.bottom + window.scrollY}px`; // Abaixo do botão
    modalNotificacoes.style.left = `${rect.left - 100}px`;
    modalNotificacoes.style.height = "50vh";
}

// Abre o modal
abrirNotificacoes.onclick = () => {
    if (auxNotificacoes == 0){
        posicionarModal();
        modalNotificacoes.classList.add("show");
        auxNotificacoes = 1;
    } else{
        modalNotificacoes.classList.remove("show");
        auxNotificacoes = 0;
    }
}

// Fecha o modal ao clicar fora do conteúdo
window.onclick = (event) => {
    if (event.target == modalNotificacoes) {
        modalNotificacoes.classList.remove("show");
    }
}

document.getElementById('busca').addEventListener('input', () => {
    var busca = document.getElementById('busca').value;
    var xhr = new XMLHttpRequest();

    if (busca.length > 0) {
        xhr.open('GET', 'buscar.php?termo=' + encodeURIComponent(busca), true);
    } else {
        xhr.open('GET', 'buscar.php', true);
    }
    
    xhr.onreadystatechange = () => {
        var resultadosDiv = document.getElementById('listaProjetos');
        resultadosDiv.innerHTML = '';

        try{
            var resultados = JSON.parse(xhr.responseText);

            if (resultados.length > 0) {
                resultados.forEach(function(produto) {
                    var div = document.createElement('div');
                    div.textContent = produto.nome;
                    resultadosDiv.appendChild(div);
                });
            } else {
                resultadosDiv.textContent = 'Nenhum resultado encontrado.';
            }
        } catch (erro) {
            console.error("Ocorreu um erro:", erro.message);
        }
    };
    xhr.send();
});