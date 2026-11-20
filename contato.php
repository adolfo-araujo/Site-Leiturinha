<?php
require_once __DIR__ . '/config/database.php';

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if($nome === '' || $email === '' || $mensagem === ''){
    header("Location: contato.html?status=erro");
    exit();
}

$stmt = $pdo->prepare("
    INSERT INTO contato (nome, email, mensagem)
    VALUES (:nome, :email, :mensagem)
");

$stmt->execute([
    ':nome' => $nome,
    ':email' => $email,
    ':mensagem' => $mensagem
]);

header("Location: contato.html?status=sucesso");
exit();
?>