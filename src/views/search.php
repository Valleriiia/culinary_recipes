<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результати пошуку</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="#" class="logo">
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
    <div class="search">
        <form action="../public/search.php" method="GET">
            <input class="search-input" type="search" name="q" placeholder="Пошук рецептів">
            <button type="submit" hidden>Знайти</button>
        </form>
    </div>
    <h1>Результати пошуку</h1>

    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $recipe): ?>
                <li>
                    <a href="/public/recipe.php?id=<?= htmlspecialchars($recipe['id']) ?>">
                        <?= htmlspecialchars($recipe['name']) ?>
                    </a>
                    <p><?= htmlspecialchars(substr($recipe['description'], 0, 100)) ?>...</p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>За вашим запитом нічого не знайдено.</p>
    <?php endif; ?>

    <a href="/public/index.php">Повернутися на головну</a>
</body>
</html>
