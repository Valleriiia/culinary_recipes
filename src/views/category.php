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
                <img src="../images/LOGO.png" alt="Кошик" height="90">
            </a>
            <div class="right-nav">
                <div class="nav-icons">
                     <div class="dropdown">
                            <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
                                <a href="../public/favorites.php" class="dropdown-toggle" title="Перехід до збережених рецептів" id="openFavoritesPage">
                                    <img src="../svg/2.svg" height="42">
                                </a>
                                <a href="#" class="dropdown-toggle" title="Перехід до профілю користувача" id="openUserPage">
                                    <img src="../svg/1.svg" height="42">
                                </a>
                                <div class="dropdown-menu">
                                    <a href="../public/user.php" class="dropdown-item">Мій профіль</a> 
                                    <a href="#" class="dropdown-item" id="logout-link">Вийти</a>
                                </div>
                                <form id="logout-form" action="../public/logout.php" method="POST" style="display: none;">
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
        <div class="category-heading">
            <h2><?= htmlspecialchars($category['name']); ?></h2>
            <p><?= htmlspecialchars($category['description']); ?></p>
        </div>
        <!-- Фільтр за інгредієнтами -->
        <aside>
        <form method="GET" action="../public/category.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']); ?>">
            <h3 class="filter-heading">Фільтрувати:</h3>
            <div class="filter-container">
            <?php foreach ($ingredients as $ingredient): ?>
                <label>
                    <?= htmlspecialchars($ingredient['name']); ?>
                    <input 
                        type="checkbox" 
                        name="ingredients[]" 
                        value="<?= $ingredient['id']; ?>"
                        <?= in_array($ingredient['id'], $selectedIngredients) ? 'checked' : ''; ?>
                    >
                </label>
            <?php endforeach; ?>
            </div>
            <button class="filter-button" type="submit">Застосувати фільтри</button>
            <a href="../public/category.php?id=<?= htmlspecialchars($category['id']); ?>" style="margin-left: 10px;">Скинути фільтри</a>
        </form>
        </aside>
        <!-- Відображення страв -->
         <section>
            <?php if (!empty($recipes)): ?>
                <ul class="recipes-list">
                    <?php foreach ($recipes as $recipe): ?>
                        <li>
                            <a href="../public/recipe.php?id=<?= $recipe['id']; ?>">
                                <div class="image-container" style="background: linear-gradient(179.91deg, #1D1D1D -43.99%, rgba(29, 29, 29, 0) 23.35%), url('../images/<?php echo htmlspecialchars($recipe['photo']) ?>');">                  
                                    <form id="favorite-form-<?= $recipe['id']; ?>" action="update_favorites.php" method="POST" onsubmit="return false;">
                                        <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                                        <button type="button" class="favorite-btn" onclick="toggleFavoriteIcon(this, <?= $recipe['id']; ?>)">
                                            <?php if ($isRecipeAdded): ?>
                                                <img src="../svg/6.svg" alt="Видалити з обраного" class="favorite-icon">
                                            <?php else: ?>
                                                <img src="../svg/5.svg" alt="Додати в обране" class="favorite-icon">
                                            <?php endif; ?>
                                        </button>
                                    </form>
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
                <p class="not-found">Нічого не знайдено.</p>
            <?php endif; ?>
         </section>
        
    </main>

    <script>
        const icons = document.querySelectorAll('.toggle-color');

        icons.forEach(icon => {
            icon.addEventListener('click', (event) => {
                event.preventDefault();
                icon.classList.toggle('active');
            });
        });

        function submitFavoriteForm(recipeId) {
            const form = document.getElementById('favorite-form-' + recipeId);
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Помилка при відправці форми:', error);
            });
        }

        document.querySelector('.save-button').addEventListener('click', function(event) {
            event.preventDefault();

            const form = document.getElementById('favorite-form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Помилка при відправці форми:', error);
            });
        });

        function toggleFavoriteIcon(button, recipeId) {
            const icon = button.querySelector('.favorite-icon');
            const form = document.getElementById('favorite-form-' + recipeId);
            const formData = new FormData(form);
            event.preventDefault();

            if (icon.src.includes('5.svg')) {
                icon.src = "../svg/6.svg"; 
            } else {
                icon.src = "../svg/5.svg"; 
            }

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    console.log(data.message);
                }
            })
            .catch(error => {
                console.error('Помилка при відправці форми:', error);
            });
        }
    </script>


    <script src="/js/scripts.js"></script>
</body>
</html>
