<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

    <div class="hero-section">
        <h1>Заряджайте своє тіло та душу – <br> знаходьте рецепти, що неймовірно смакують!</h1>
        <form action="../public/search.php" method="GET">
            <input class="search-input" type="search" name="q" autocomplete="off" placeholder="Пошук за стравою, інгредієнтами...">
            <button type="submit" hidden></button>
        </form>
        <div class="darkener-overlay"></div>
    </div>

    <main>
        <h2 class="search-heading">Категорії рецептів</h2>
        <div class="categories-list">
            <ul>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="category.php?id=<?= $category['id']; ?> ">
                                <div class="category-container" style="background:  url('../images/Darkener.png'), url('../images/<?php echo htmlspecialchars($category['category_photo']) ?>');">
                                    <p class="category-name"><?= htmlspecialchars($category['name']); ?></p>
                                    <p class="description"><?php echo htmlspecialchars($category['description']); ?></p>
                                </div>
                                
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Категорій не знайдено.</p>
                <?php endif; ?>
            </ul>
        </div>
        
    </main>

    <script>
    document.querySelector('#logout-link').addEventListener('click', function(e) {
        e.preventDefault();  
        document.querySelector('#logout-form').submit();  
    });
    </script>

    <footer>
        <p>&copy; 2024 Kitchen Tales. Всі права захищені.</p>
    </footer>
</body>
</html>
