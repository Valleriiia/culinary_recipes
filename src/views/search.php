<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результати пошуку</title>
</head>
<body>
    <form action="/dashboard/recipes/public/search.php" method="GET">
        <input type="text" name="q" placeholder="Пошук рецептів">
        <button type="submit">Знайти</button>
    </form>
    <h1>Результати пошуку</h1>

    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $recipe): ?>
                <li>
                    <a href="/recipe.php?id=<?= htmlspecialchars($recipe['id']) ?>">
                        <?= htmlspecialchars($recipe['name']) ?>
                    </a>
                    <p><?= htmlspecialchars(substr($recipe['description'], 0, 100)) ?>...</p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>За вашим запитом нічого не знайдено.</p>
    <?php endif; ?>

    <a href="/">Повернутися на головну</a>
</body>
</html>
