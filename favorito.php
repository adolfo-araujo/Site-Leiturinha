<?php
require_once __DIR__ . '/config/database.php';

$id_livro = (int)($_GET['id_livro'] ?? 0);

if($id_livro > 0){

    $verifica = $pdo->prepare("
        SELECT id_favorito 
        FROM favorito 
        WHERE id_livro = ?
    ");
    $verifica->execute([$id_livro]);

    if(!$verifica->fetch()){
        $stmt = $pdo->prepare("
            INSERT INTO favorito (id_livro)
            VALUES (?)
        ");
        $stmt->execute([$id_livro]);

        header("Location: index.php?fav=sucesso");
        exit();
    }else{
        header("Location: index.php?fav=existe");
        exit();
    }
}

header("Location: index.php?fav=erro");
exit();
