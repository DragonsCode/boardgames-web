<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$username, $email, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardGames.uz - Регистрация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>BoardGames.uz</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="catalog.php">Каталог</a>
            <a href="demo.html">Демо</a>
            <a href="about.html">О нас</a>
            <a href="login.php">Вход</a>
        </nav>
    </header>
    <main>
        <h2>Регистрация</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </main>
    <footer>
        <p>© 2025 BoardGames.uz</p>
    </footer>
</body>
</html>