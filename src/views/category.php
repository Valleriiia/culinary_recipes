<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категорія страв</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <form action="/public/search.php" method="GET">
        <input type="text" name="q" placeholder="Пошук рецептів">
        <button type="submit">Знайти</button>
    </form>
    <h1>Страви в категорії: <?= htmlspecialchars($category['name']); ?></h1>

    <!-- Фільтр за інгредієнтами -->
    <form method="GET" action="/public/category.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']); ?>">
        <h3>Фільтрувати за інгредієнтами:</h3>
        <?php foreach ($ingredients as $ingredient): ?>
            <label>
                <input 
                    type="checkbox" 
                    name="ingredients[]" 
                    value="<?= $ingredient['id']; ?>"
                    <?= in_array($ingredient['id'], $selectedIngredients) ? 'checked' : ''; ?>
                >
                <?= htmlspecialchars($ingredient['name']); ?>
            </label><br>
        <?php endforeach; ?>
        <button type="submit">Застосувати фільтри</button>
        <a href="/public/category.php?id=<?= htmlspecialchars($category['id']); ?>" style="margin-left: 10px;">Скинути фільтри</a>
    </form>

    <!-- Відображення страв -->
    <ul>
        <?php foreach ($recipes as $recipe): ?>
            <li>
                <a href="../public/recipe.php?id=<?= $recipe['id']; ?>"><?= htmlspecialchars($recipe['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script src="/js/scripts.js"></script>
</body>
</html>
