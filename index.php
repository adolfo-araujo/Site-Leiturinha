<?php
require_once __DIR__ . '/config/database.php';

$stmt = $pdo->query("
    SELECT livro.id_livro, livro.titulo, autor.nome_autor
    FROM livro
    INNER JOIN autor ON livro.id_autor = autor.id_autor
    ORDER BY livro.id_livro ASC
");

$livros = $stmt->fetchAll();

$capas = [
  1 => "https://m.media-amazon.com/images/I/81LTEfXYgcL.jpg",
  2 => "https://m.media-amazon.com/images/I/71SliYa-JkL.jpg",
  3 => "https://m.media-amazon.com/images/I/81Q11TuUR3L.jpg",
  4 => "https://m.media-amazon.com/images/I/81gOkEhzgIL._UF1000,1000_QL80_.jpg",
  5 => "https://m.media-amazon.com/images/I/81WKPIFKThL.jpg",
  6 => "https://m.media-amazon.com/images/I/81d6ESyPZwL.jpg"
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leiturinha</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <header class="topo">
    <a href="index.php" class="logo">📖 Leiturinha</a>

    <div class="busca-area">
      <input type="text" id="busca" placeholder="Pesquisar livro...">
      <button onclick="pesquisarLivro()">🔍</button>
    </div>
  </header>

  <nav class="menu">
    <a href="index.php">Home</a>
    <a href="favoritos.php">Favoritos</a>
    <a href="#marca">Sobre</a>
    <a href="contato.html">Contato</a>
    <a href="create.php">Adicionar Livro</a>
  </nav>

  <section class="faixa-cinza"></section>

  <section class="hero">
    <div class="hero-img"></div>

    <div class="hero-texto">
      <h1>Bem-vindo à nossa<br>loja de leitura!</h1>

      <div class="caixa-frase">
        Ler é um hábito poderoso que estimula a imaginação, melhora a escrita,
        amplia o vocabulário e ajuda a relaxar. Além de ensinar, a leitura nos
        faz entender melhor o mundo e as pessoas ao nosso redor.
      </div>
    </div>
  </section>

  <section class="titulo-secao">
    <p>Top Romances para se Apaixonar:</p>
  </section>

  <section class="lista-livros">
    <?php foreach($livros as $livro): ?>
      <?php
        $id = (int) $livro['id_livro'];
        $titulo = $livro['titulo'];
        $autor = $livro['nome_autor'];
        $capa = $capas[$id] ?? "https://via.placeholder.com/300x450?text=Sem+Capa";
      ?>

      <div class="livro-card" data-titulo="<?= htmlspecialchars(mb_strtolower($titulo, 'UTF-8')) ?>">
        <img src="<?= htmlspecialchars($capa) ?>" alt="<?= htmlspecialchars($titulo) ?>">
        <h3><?= htmlspecialchars($titulo) ?></h3>
        <p><?= htmlspecialchars($autor) ?></p>

        <div class="acoes-card">
  <a href="produto.php?id=<?= $id ?>">Ver mais</a>
 <a href="favorito.php?id_livro=<?= $id ?>">♡</a>
</div>
       
        <div class="acoes-card admin-acoes">
          <a href="edit.php?id=<?= $id ?>">Editar</a>
          <a href="delete.php?id=<?= $id ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?')">Excluir</a>
        </div>
      </div>
    <?php endforeach; ?>
  </section>

  <section class="grandes-estrelas">
    <div class="frases">
      <h2>GRANDES ESTRELAS DA LEITURA</h2>

      <div class="frase-box">“Ler é sonhar pela mão do autor.”<br>— Fernando Pessoa</div>
      <div class="frase-box">“A leitura é uma outra maneira de estar em um lugar.”<br>— José Saramago</div>
      <div class="frase-box">“O livro é um bom amigo.”<br>— André Maurois</div>
    </div>

    <div class="autores">
      <div class="autor-img">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/32/Pessoa_chapeu.jpg/250px-Pessoa_chapeu.jpg" alt="Autor 1">
      </div>
      <div class="autor-img">
        <img src="https://cdl-static.s3-sa-east-1.amazonaws.com/colaboradores/00445_gg.jpg" alt="Autor 2">
      </div>
      <div class="autor-img">
        <img src="https://fantastic-writers-and-the-great-war.com/wp-content/uploads/2014/03/andre-maurois-in-uniform.jpg" alt="Autor 3">
      </div>
    </div>

    <div class="imagem-destaque"></div>
  </section>

  <section class="marca" id="marca">
    <div class="texto-marca">
      <h2>A História por Trás da Marca</h2>
      <p>
        Tudo começou com uma paixão simples: o amor pelos livros. Desde pequena,
        nossa fundadora se encantava com o poder que as histórias tinham de
        transportar pessoas para outros mundos, de ensinar, emocionar e transformar vidas.
      </p>
      <p>
        Assim nasceu a ideia de criar um espaço onde livros de todos os tipos
        pudessem encontrar novos leitores.
      </p>
      <p>
        Aqui, cada página é uma promessa de aventura, cada autor uma estrela,
        e cada leitor, um explorador do conhecimento.
      </p>
    </div>
  </section>

  <footer class="rodape">
    <a class="btn-contato" href="contato.html">Fale conosco</a>
    <div class="redes">
      <span>🐦</span>
      <span>📷</span>
      <span>✈️</span>
      <span>📘</span>
    </div>
  </footer>

  <script src="assets/js/script.js"></script>
  <script>
  const params = new URLSearchParams(window.location.search);
  const fav = params.get("fav");

  if(fav === "sucesso"){
    alert("Livro adicionado aos favoritos!");
  }

  if(fav === "existe"){
    alert("Esse livro já está nos favoritos.");
  }

  if(fav === "erro"){
    alert("Erro ao adicionar aos favoritos.");
  }
</script>
</body>
</html>
