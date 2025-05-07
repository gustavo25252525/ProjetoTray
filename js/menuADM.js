

var menuItem = document.querySelectorAll('.item-menu')

function selecionarLink(){
    menuItem.forEach((item)=>
        item.classList.remove('ativos'))
    
    this.classList.add('ativos')
}

menuItem.forEach((item)=> item.addEventListener('click', selecionarLink)
) 


document.getElementById('homeLink').addEventListener('click', function(event) {
    event.preventDefault(); // Previne o comportamento padrão do link
    document.getElementById('homeContent').style.display = 'block'; // Mostra a div Home1
  });
  
  document.getElementById('funcionarioLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('homeContent').style.display = 'none'; // Esconde a div Home1
  });
  
  document.getElementById('clienteLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('homeContent').style.display = 'none'; // Esconde a div Home1
  });