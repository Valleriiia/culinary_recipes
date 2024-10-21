<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Користувач</title>
</head>
<body>
    <h2>Ласкаво просимо, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Гість'; ?>!</h2>
    <p>Ви успішно увійшли на сайт.</p>

    <form method="post" action="">
        <button type="submit" name="logout">Вийти</button> 
    </form>
</body>
</html>
