<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else {
        echo "Неверные данные!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardGames.uz - Вход</title>
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
            <a href="register.php">Регистрация</a>
        </nav>
    </header>
    <main>
        <h2>Вход</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
    </main>
    <footer>
        <p>© 2025 BoardGames.uz</p>
    </footer>
</body>
</html>