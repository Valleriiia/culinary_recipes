<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результати пошуку</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/category.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo">
                <img src="../images/LOGO.png" alt="Кошик" height="90">
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
                                    <img src="../svg/2.svg" height="42">
                                </a>
                                <a href="#" class="dropdown-toggle" title="Перехід до профілю користувача" id="openUserPage">
                                    <img src="../svg/1.svg" height="42">
                                </a>
                                <div class="dropdown-menu">
                                    <a href="../public/user.php" class="dropdown-item">Мій профіль</a> 
                                    <a href="#" class="dropdown-item" id="logout-link">Вийти</a>
                                </div>
                                <form id="logout-form" action="/logout.php" method="POST" style="display: none;">
                                    <input type="hidden" name="logout" value="true">
                                </form>
                            </div>
                        <?php else: ?>
                            <form action="../public/login.php" method="get">
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
        <section>
            <h2 class="search-heading">Результати пошуку</h2>

            <?php if (!empty($results)): ?>
                <ul class="recipes-list">
                    <?php foreach ($results as $recipe): ?>
                        <li>
                            <a href="../public/recipe.php?id=<?= $recipe['id']; ?>">
                                <div class="image-container" style="background: linear-gradient(179.91deg, #1D1D1D -43.99%, rgba(29, 29, 29, 0) 23.35%), url('../images/<?php echo htmlspecialchars($recipe['photo']) ?>');">
                                    <div class="save-button"><img src="../svg/5.svg" alt="save"></div>
                                </div>
                                <div class="recipe-details">
                                    <h4><?= htmlspecialchars($recipe['name']); ?></h4>
                                    <p class="cooking-time">Час приготування: <?= $recipe['cooking_time']; ?> хв</p>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php $fillPercentage = max(0, min(100, ($ratings[$recipe['id']]['average'] - $i + 1) * 100)); ?>
                                            <div class="star" style="background: linear-gradient(90deg, #407948 <?php echo $fillPercentage; ?>%, lightgray <?php echo (100 - $fillPercentage); ?>%);"></div>
                                        <?php endfor; ?>
                                        <p>(<?= htmlspecialchars($ratings[$recipe['id']]['count']); ?>)</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="not-found">За вашим запитом нічого не знайдено.</p>
            <?php endif; ?>
        </section>
    </main>
    

    <a class="return" href="/public/index.php">Повернутися на головну</a>
</body>
</html>
