<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['name']); ?></title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <header>
        <a href="/"><img src="/public/images/logo.png" alt="Логотип"></a>
        <form action="/dashboard/recipes/public/search.php" method="GET">
            <input type="text" name="q" placeholder="Пошук рецептів">
            <button type="submit">Знайти</button>
        </form>
    </header>

    <main>
        <h1><?= htmlspecialchars($recipe['name']); ?></h1>
        <img src=<?= htmlspecialchars($recipe['photo']); ?> alt=<?= htmlspecialchars($recipe['name']); ?>>
        <p><?= htmlspecialchars($recipe['description']); ?></p>
        <p><strong>Час приготування:</strong> <?= htmlspecialchars($recipe['cooking_time']); ?> хвилин</p>
        <p><strong>Складність:</strong> <?= htmlspecialchars($recipe['complexity']); ?></p>
        <p><strong>Інгредієнти:</strong></p>
        <ul>
            <?php foreach ($ingredients as $ingredient): ?>
                <li><?= htmlspecialchars($ingredient['name']); ?> <?=htmlspecialchars($ingredient['quantity']); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Інструкція:</strong></p>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])); ?></p>

        <section>
            <h2>Оцінка рецепту</h2>
            <?php if ($ratings['count'] > 0): ?>
                <p>Середня оцінка: <?= number_format($ratings['average'], 1); ?> (<?= $ratings['count']; ?> оцінок)</p>
            <?php else: ?>
                <p>Ще немає оцінок.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Відгуки</h2>
            <?php if (!empty($reviews)): ?>
                <ul>
                    <?php foreach ($reviews as $review): ?>
                        <li>
                            <strong><?= htmlspecialchars($review['name']); ?></strong> (<?= htmlspecialchars($review['date']); ?>):
                            <p><?= nl2br(htmlspecialchars($review['text'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Відгуків ще немає.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Додати відгук</h2>
            <form action="/add_review.php" method="POST">
                <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                <textarea name="comment" placeholder="Напишіть свій відгук" required></textarea>
                <button type="submit">Додати</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Ваш кулінарний сайт</p>
    </footer>
</body>
</html>
