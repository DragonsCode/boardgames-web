<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardGames.uz - Сертификаты</title>
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
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Выход</a>
            <?php else: ?>
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <section>
            <h2>Мои сертификаты</h2>
            <ul>
                <li><a href="/certificates/cert1.pdf">Сертификат по HTML/CSS</a></li>
                <li><a href="/certificates/cert2.pdf">Сертификат по PHP</a></li>
            </ul>
        </section>
    </main>
    <footer>
        <p>© 2025 BoardGames.uz</p>
    </footer>
</body>
</html>