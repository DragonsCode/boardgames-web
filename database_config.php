<?php
function database_config(): array {
    $required = function (string $name): string {
        $value = getenv($name);
        if ($value === false || trim($value) === '') {
            throw new RuntimeException('Required database configuration is missing');
        }
        return $value;
    };
    $host = getenv('DB_HOST') ?: 'localhost';
    $name = getenv('DB_NAME') ?: 'boardgames';
    return [
        'dsn' => "mysql:host=$host;dbname=$name;charset=utf8mb4",
        'user' => $required('DB_USER'),
        'password' => $required('DB_PASSWORD'),
    ];
}
