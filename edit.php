<?php
require_once __DIR__ . '/config/database.php';

$id = (int)($_GET['id'] ?? 0);

if($id <= 0){
    header("Location: index.php");
    exit();
}

$autores = $pdo->query("SELECT id_autor, nome_autor FROM autor ORDER BY nome_autor ASC")->fetchAll();
$erro = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = trim($_POST['titulo'] ?? '');
    $id_autor = (int)($_POST['id_autor'] ?? 0);
    $sinopse = trim($_POST['sinopse'] ?? '');
    $editora = trim($_POST['editora'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');

    if($titulo === '' || $id_autor <= 0){
        $erro = "Preencha o título e escolha um autor.";
    }else{
        $stmt = $pdo->prepare("
            UPDATE livro
            SET titulo = :titulo,
                id_autor = :id_autor,
                sinopse = :sinopse,
                editora = :editora,
                tipo = :tipo
            WHERE id_livro = :id
        ");

        $stmt->execute([
            ':titulo' => $titulo,
            ':id_autor' => $id_autor,
            ':sinopse' => $sinopse,
            ':editora' => $editora,
            ':tipo' => $tipo,
            ':id' => $id
        ]);

        header("Location: index.php");
        exit();
    }
}

$stmt = $pdo->prepare("SELECT * FROM livro WHERE id_livro = :id");
$stmt->execute([':id' => $id]);
$livro = $stmt->fetch();

if(!$livro){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Livro</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topo">
  <a href="index.php" class="logo">📖 Leiturinha</a>
</header>

<nav class="menu">
  <a href="index.php">Home</a>
  <a href="favoritos.php">Favoritos</a>
  <a href="contato.html">Contato</a>
</nav>

<section class="form-crud">
  <h1>Editar Livro</h1>

  <?php if($erro): ?>
    <p class="erro-crud"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>

  <form method="post" class="formulario">
    <input type="text" name="titulo" value="<?= htmlspecialchars($livro['titulo'] ?? '') ?>" required>

    <select name="id_autor" required>
      <?php foreach($autores as $autor): ?>
        <option value="<?= $autor['id_autor'] ?>" <?= ((int)$livro['id_autor'] === (int)$autor['id_autor']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($autor['nome_autor']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="editora" value="<?= htmlspecialchars($livro['editora'] ?? '') ?>" placeholder="Editora">
    <input type="text" name="tipo" value="<?= htmlspecialchars($livro['tipo'] ?? '') ?>" placeholder="Tipo">
    <textarea name="sinopse" placeholder="Sinopse"><?= htmlspecialchars($livro['sinopse'] ?? '') ?></textarea>

    <button type="submit">Salvar Alteração</button>
  </form>
</section>
</body>
</html>
