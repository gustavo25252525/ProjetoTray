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

const modal = document.getElementById("meuModal");
const openModal = document.getElementById("criar");
const closeModal = document.getElementById("fecharModal");

// Abre o modal
openModal.onclick = () => {
    modal.classList.add("show");
}

// Fecha o modal
closeModal.onclick = () => {
    modal.classList.remove("show");
}

// Fecha o modal ao clicar fora do conteúdo
window.onclick = (event) => {
    if (event.target == modal) {
        modal.classList.remove("show");
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