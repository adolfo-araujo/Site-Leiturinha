<?php
/**
 * Conexão PDO compartilhada pelas páginas PHP.
 * Preferência: config/database.local.php (não versionado), depois variáveis de ambiente.
 */
$config = [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'name' => getenv('DB_NAME') ?: 'leiturinha',
    'user' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => 'utf8mb4',
];

$localFile = __DIR__ . '/database.local.php';
if (is_file($localFile)) {
    $local = require $localFile;
    if (!is_array($local)) {
        http_response_code(500);
        exit('Configuração local inválida.');
    }
    $config = array_replace($config, $local);
}

$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    $config['host'],
    $config['name'],
    $config['charset']
);

try {
    $pdo = new PDO($dsn, $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $error) {
    error_log('[Leiturinha] Falha na conexão com MySQL: ' . $error->getMessage());
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Confira a configuração.');
}
