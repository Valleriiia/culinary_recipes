<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна сторінка</title>
</head>
<body>
    <h1>Вітаємо, <?php echo htmlspecialchars($user_name ?? 'Гість'); ?>!</h1>

    <p>Ласкаво просимо на сайт!</p>

    <?php if (isset($isLoggedIn) && !$isLoggedIn): ?>
        <form action="/public/login.php" method="get">
            <button type="submit">Увійти</button>
        </form>
    <?php else: ?>
        <form action="" method="post"> 
            <button type="submit" name="logout">Вийти</button>
        </form>
    <?php endif; ?>
</body>
</html>
