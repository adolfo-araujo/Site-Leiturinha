<?php 
require_once __DIR__ . '/config/database.php'; 

$erro = "";
 
if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

$titulo = trim($_POST['titulo'] ?? ''); 
$sinopse = trim($_POST['sinopse'] ?? ''); 
$editora = trim($_POST['editora'] ?? ''); 
$tipo = trim($_POST['tipo'] ?? ''); 
$nome_autor = trim($_POST['nome_autor'] ?? ''); 

if($titulo === '' || $nome_autor === ''){ 
$erro = "Preencha o título e o nome do autor."; 
}else{

$stmt = $pdo->prepare(" 

SELECT id_autor 
FROM autor 
WHERE nome_autor = ? 
"); 

$stmt->execute([$nome_autor]); 
$autor = $stmt->fetch(); 

if($autor){ 
$id_autor = $autor['id_autor']; 
}else{ 

$stmt = $pdo->prepare(" 
INSERT INTO autor (nome_autor) 
VALUES (?) 
"); 

$stmt->execute([$nome_autor]); 

$id_autor = $pdo->lastInsertId(); 
} 

$stmt = $pdo->prepare(" 
INSERT INTO livro 
(titulo, sinopse, editora, tipo, id_autor) 
VALUES 
(:titulo, :sinopse, :editora, :tipo, :id_autor) "); 

$stmt->execute([ 
':titulo' => $titulo, 
':sinopse' => $sinopse, 
':editora' => $editora, 
':tipo' => $tipo, 
':id_autor' => $id_autor
 ]); 

header("Location: index.php"); 
exit(); 
} 
} 
?> 

<!DOCTYPE html>
 <html lang="pt-BR">
 <head> 
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Livro</title> 
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

<h1>Adicionar Livro</h1> 

<?php if($erro): ?> 
<p class="erro-crud"><?= htmlspecialchars($erro) ?></p>
 <?php endif; ?> 

<form method="post" class="formulario"> 
<input type="text" name="titulo" placeholder="Título do livro" required> 
<input type="text" name="nome_autor" placeholder="Nome do autor" required> 

<input type="text" name="editora" placeholder="Editora">
 <input type="text" name="tipo" placeholder="Tipo. Ex: Romance">
 <textarea name="sinopse" placeholder="Sinopse" ></textarea> 

<button type="submit">Salvar</button> 
</form> 
</section> 
</body> 
</html>