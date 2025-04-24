<?php
$host = 'localhost';
$dbname = 'boardgames';
$user = 'root'; // Замени на своего пользователя
$pass = 'Root007!'; // Замени на свой пароль

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>