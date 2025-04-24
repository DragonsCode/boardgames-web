<?php
session_start();
include 'db.php';

$stmt = $pdo->query("SELECT * FROM games LIMIT 2");
$games = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoardGames.uz - Главная</title>
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
        <section class="slider">
            <h2>Акции недели!</h2>
            <div class="slide">Игра "Шахматы" — скидка 20%</div>
        </section>
        <section class="popular">
            <h2>Популярные игры</h2>
            <?php foreach ($games as $game): ?>
                <div class="game-card"><?= htmlspecialchars($game['title']) ?> — $<?= $game['price'] ?></div>
            <?php endforeach; ?>
            <button onclick="window.location.href='demo.html'">Попробовать демо</button>
        </section>
    </main>
    <footer>
        <p>© 2025 BoardGames.uz</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>