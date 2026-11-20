-- Banco de dados do projeto Leiturinha - AP2
-- INFINITYFREE: crie o banco pelo painel MySQL Databases.
-- Depois abra o phpMyAdmin e execute este script.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS favorito;
DROP TABLE IF EXISTS contato;
DROP TABLE IF EXISTS livro;
DROP TABLE IF EXISTS autor;

CREATE TABLE autor (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nome_autor VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE livro (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    sinopse TEXT NOT NULL,
    editora VARCHAR(100) NOT NULL,
    imagem VARCHAR(255),
    tipo VARCHAR(50) DEFAULT 'Livro',
    id_autor INT NOT NULL,
    CONSTRAINT fk_livro_autor FOREIGN KEY (id_autor) REFERENCES autor(id_autor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE favorito (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_livro INT NOT NULL,
    data_favorito DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_favorito_livro FOREIGN KEY (id_livro) REFERENCES livro(id_livro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE contato (
    id_contato INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO autor (nome_autor) VALUES
('Ali Hazelwood'),
('Elena Armas'),
('Rachel Lippincott'),
('Jane Austen'),
('Leigh Bardugo'),
('J. K. Rowling');

INSERT INTO livro (titulo, sinopse, editora, imagem, tipo, id_autor) VALUES
('A Hipótese do Amor', 'Quando um relacionamento falso entre cientistas encontra a irresistível força da atração, as teorias de uma mulher sobre o amor são colocadas à prova.', 'Desrotina', 'https://m.media-amazon.com/images/I/81LTEfXYgcL.jpg', 'Livro e Ebook', 1),
('Uma Farsa de Amor', 'É um romance que narra a história de Catalina Martín, uma jovem engenheira que precisa de um acompanhante para o casamento da irmã na Espanha.', 'Arqueiro', 'https://m.media-amazon.com/images/I/71SliYa-JkL.jpg', 'Livro e Ebook', 2),
('A Cinco Passos de Você', 'Stella e Will, dois jovens que são portadores de fibrose cística, se apaixonam, mas precisam viver com distância física e muitos limites.', 'Desrotina', 'https://m.media-amazon.com/images/I/81Q11TuUR3L.jpg', 'Livro e Ebook', 3),
('Orgulho e Preconceito', 'Quando Elizabeth Bennet conhece Fitzwilliam Darcy, ela logo o julga arrogante. Mas aos poucos, as primeiras impressões vão mudando.', 'Martin Claret', 'https://m.media-amazon.com/images/I/81gOkEhzgIL._UF1000,1000_QL80_.jpg', 'Livro e Ebook', 4),
('Sombra e Ossos', 'Depois da morte da mãe, Lina vai para a Itália e acaba vivendo uma história de amor, descobertas e mudanças.', 'Intrínseca', 'https://m.media-amazon.com/images/I/81WKPIFKThL.jpg', 'Livro e Ebook', 5),
('Harry Potter e A Ordem Da Fênix', 'Harry continua sua jornada em Hogwarts enfrentando novas investigações, perigos e descobertas sobre o passado de sua família.', 'Rocco', 'https://m.media-amazon.com/images/I/81d6ESyPZwL.jpg', 'Livro e Ebook', 6);
