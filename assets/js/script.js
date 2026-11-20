function adicionarFavorito(nomeLivro){
  let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

  if(!favoritos.includes(nomeLivro)){
    favoritos.push(nomeLivro);
    localStorage.setItem("favoritos", JSON.stringify(favoritos));
    alert("Livro adicionado aos favoritos.");
  }else{
    alert("Esse livro já está nos favoritos.");
  }
}

function mostrarFavoritos(){
  let area = document.getElementById("listaFavoritos");
  if(!area || area.dataset.serverRendered === "true") return;

  let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

  if(favoritos.length === 0){
    area.innerHTML = "Sua lista está vazia.";
  }else{
    let texto = "";

    for(let i = 0; i < favoritos.length; i++){
      texto += `
        <div class="item-favorito">
          <span>${favoritos[i]}</span>
          <button onclick="removerFavorito(${i})">Remover</button>
        </div>
      `;
    }

    area.innerHTML = texto;
  }
}

function removerFavorito(index){
  let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

  favoritos.splice(index, 1);

  localStorage.setItem("favoritos", JSON.stringify(favoritos));

  mostrarFavoritos();
}

function pesquisarLivro(){
  let busca = document.getElementById("busca");
  if(!busca) return;

  let valor = busca.value.toLowerCase().trim();
  let cards = document.querySelectorAll(".livro-card");
  let encontrou = false;

  cards.forEach(function(card){
    let titulo = (card.getAttribute("data-titulo") || card.innerText).toLowerCase();

    if(valor === "" || titulo.includes(valor)){
      card.style.display = "block";
      encontrou = true;
    }else{
      card.style.display = "none";
    }
  });

  if(!encontrou){
    alert("Livro não encontrado.");
  }
}

const formContato = document.getElementById("formContato");
if(formContato){
  formContato.addEventListener("submit", function(e){

    let nome = document.getElementById("nomeContato").value.trim();
    let email = document.getElementById("emailContato").value.trim();
    let mensagem = document.getElementById("mensagemContato").value.trim();
    let msg = document.getElementById("msgContato");

    if(nome === "" || email === "" || mensagem === ""){
      msg.innerText = "Preencha todos os campos.";
      return;
    }

    if(!email.includes("@") || !email.includes(".")){
      msg.innerText = "Digite um e-mail válido.";
      return;
    }

    msg.style.color = "green";
    msg.innerText = "Mensagem enviada com sucesso!";
  });
}

mostrarFavoritos();
