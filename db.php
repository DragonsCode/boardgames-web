<?php
require_once __DIR__ . '/database_config.php';
try {
    $config = database_config();
    $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    unset($config);
} catch (Throwable $error) {
    // Never expose PDO connection strings, credentials or internal exception messages.
    error_log('Database connection unavailable: ' . get_class($error));
    http_response_code(503);
    exit('Database service unavailable.');
}
