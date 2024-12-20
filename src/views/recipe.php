<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['name']); ?></title>
    <link rel="stylesheet" href="../public/css/recipes.css">
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
        <a href="/"><img src="/public/images/logo.png" alt="Логотип"></a>
        <form action="../public/search.php" method="GET">
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
                            <p>Оцінка: <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></p>
                            <p><?= htmlspecialchars($review['text'] ?? 'Без коментаря'); ?></p>
                            <p><small><?= $review['date']; ?></small></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Відгуків ще немає.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Додати відгук</h2>
            <form action="/public/add_review.php" method="POST">
                <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">

                <div class="rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="0" required>

                <textarea name="comment" placeholder="Напишіть свій відгук (необов'язково)"></textarea>

                <button type="submit">Додати оцінку</button>
            </form>
        </section>

        <section>
            <form action="/public/favorites.php" method="POST">
                <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                <button type="submit" name="add_favorite">Додати до улюбленого</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Ваш кулінарний сайт</p>
    </footer>
    <script>
    const stars = document.querySelectorAll('.rating .star');
    const ratingInput = document.getElementById('rating');

    stars.forEach((star) => {
        star.addEventListener('click', () => {
            const value = star.dataset.value;
            ratingInput.value = value;

            stars.forEach(s => s.classList.remove('selected'));
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('selected');
            }
        });

        star.addEventListener('mouseover', () => {
            stars.forEach(s => s.classList.remove('hover'));
            for (let i = 0; i < star.dataset.value; i++) {
                stars[i].classList.add('hover');
            }
        });

        star.addEventListener('mouseout', () => {
            stars.forEach(s => s.classList.remove('hover'));
        });
    });
</script>
</body>
</html>
