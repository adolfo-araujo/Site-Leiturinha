<?php
require_once __DIR__ . '/config/database.php';

$id = (int)($_GET['id'] ?? 0);

$capas = [
  1 => "https://m.media-amazon.com/images/I/81LTEfXYgcL.jpg",
  2 => "https://m.media-amazon.com/images/I/71SliYa-JkL.jpg",
  3 => "https://m.media-amazon.com/images/I/81Q11TuUR3L.jpg",
  4 => "https://m.media-amazon.com/images/I/81gOkEhzgIL._UF1000,1000_QL80_.jpg",
  5 => "https://m.media-amazon.com/images/I/81WKPIFKThL.jpg",
  6 => "https://m.media-amazon.com/images/I/81d6ESyPZwL.jpg"
];

$stmt = $pdo->prepare("
    SELECT livro.id_livro, livro.titulo, livro.sinopse, livro.editora, livro.tipo, autor.nome_autor
    FROM livro
    INNER JOIN autor ON livro.id_autor = autor.id_autor
    WHERE livro.id_livro = ?
");

$stmt->execute([$id]);
$livro = $stmt->fetch();

if(!$livro){
    header("Location: index.php");
    exit();
}

$capa = $capas[$id] ?? "https://via.placeholder.com/300x450?text=Sem+Capa";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($livro['titulo']) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="topo">
  <a href="index.php" class="logo">📖 Leiturinha</a>
</header>

<nav class="menu">
  <a href="index.php">Home</a>
  <a href="favoritos.php">Favoritos</a>
  <a href="index.php#marca">Sobre</a>
  <a href="contato.html">Contato</a>
  <a href="create.php">Adicionar Livro</a>
</nav>

<section class="produto-pagina">

  <div class="produto-img">
    <img src="<?= htmlspecialchars($capa) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>">
  </div>

  <div class="produto-info">
    <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
    <h2><?= htmlspecialchars($livro['nome_autor']) ?></h2>

    <div class="tipos">
      <span><?= htmlspecialchars($livro['tipo'] ?: 'Livro e Ebook') ?></span>
    </div>

    <p class="mini-info">
      <strong>Editora:</strong> <?= htmlspecialchars($livro['editora'] ?: 'Não informada') ?>
    </p>

    <p class="avaliacao">★★★★★ Avaliação dos leitores</p>

    <div class="botoes-livro">
      <button onclick="adicionarFavorito('<?= htmlspecialchars($livro['titulo'], ENT_QUOTES) ?>')">
        Adicionar aos favoritos
      </button>

      <a href="index.php">Voltar</a>
    </div>
  </div>

</section>

<section class="sinopse-area">
  <h2>Sinopse</h2>

  <div class="sinopse-box">
    <?= nl2br(htmlspecialchars($livro['sinopse'] ?: 'Sinopse não cadastrada.')) ?>
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