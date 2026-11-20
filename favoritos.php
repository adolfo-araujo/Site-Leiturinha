<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Favoritos</title>
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
  <a href="contato.html">Contato</a>
</nav>

<section class="faixa-cinza"></section>

<section class="favoritos-box">
  <div class="icone-fav">♡</div>

  <div>
    <h1>Minha Lista de Desejos</h1>
    <div id="listaFavoritos" data-server-rendered="true">
  <?php
  require_once __DIR__ . '/config/database.php';

  $stmt = $pdo->query("
    SELECT livro.titulo
    FROM favorito
    INNER JOIN livro ON favorito.id_livro = livro.id_livro
    ORDER BY favorito.id_favorito DESC
  ");

  $favoritos = $stmt->fetchAll();

  if(count($favoritos) === 0){
      echo "Sua lista está vazia.";
  }else{
      foreach($favoritos as $fav){
          echo "<p>" . htmlspecialchars($fav['titulo']) . "</p>";
      }
  }
  ?>
</div>
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
</body>
</html>