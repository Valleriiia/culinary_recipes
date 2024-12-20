<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категорія страв</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/category.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo">
                <img src="../images/LOGO.png" alt="Кошик" width="115" height="60">
            </a>
            <nav class="main-nav">
                <a href="#">Рецепти</a>
                <a href="#">Інгредієнти</a>
                <a href="#">Страви</a>
            </nav>
            <div class="right-nav">
                <div class="nav-icons">
                     <div class="dropdown">
                            <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
                                <a href="#" class="dropdown-toggle" title="Перехід до збережених рецептів" id="openFavoritesPage">
                                    <img src="../svg/2.svg" width="40" height="30">
                                </a>
                                <a href="#" class="dropdown-toggle" title="Перехід до профілю користувача" id="openUserPage">
                                    <img src="../svg/1.svg" width="40" height="30">
                                </a>
                                <div class="dropdown-menu">
                                    <a href="/public/user.php" class="dropdown-item">Мій профіль</a> 
                                    <a href="#" class="dropdown-item" id="logout-link">Вийти</a>
                                </div>
                                <form id="logout-form" action="/logout.php" method="POST" style="display: none;">
                                    <input type="hidden" name="logout" value="true">
                                </form>
                            </div>
                        <?php else: ?>
                            <form action="public/login.php" method="get">
                                <button type="submit" class="login-btn">Вхід/Реєстрація</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="search">
            <form action="../public/search.php" method="GET">
                <input class="search-input" type="search" name="q" autocomplete="off" placeholder="Пошук рецептів">
                <button type="submit" hidden>Знайти</button>
            </form>
        </div>
        <div class="category-heading">
            <h2><?= htmlspecialchars($category['name']); ?></h2>
            <p><?= htmlspecialchars($category['description']); ?></p>
        </div>
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
    </main>


    <script src="/js/scripts.js"></script>
</body>
</html>
