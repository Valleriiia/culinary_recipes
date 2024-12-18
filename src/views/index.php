<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%; 
            overflow-x: hidden;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; 
            color: #000000; 
            display: flex;
            flex-direction: column;
            justify-content: space-between; 
            margin: 0;
            zoom: 1.1;
        }

        main {
            flex: 1;
        }

        .login-btn {
            background-color: #2F5333; 
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #345d41; 
        }

        .logout-form {
            display: inline-block;
        }

        .hero-section {
            position: relative;
            text-align: center;
            padding: 40px 20px;
            color: white;
            height: 55vh;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/Food.jpg') no-repeat center center/cover;
            z-index: -1;
            opacity: 1;
        }

        .hero-section .darkener-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/Darkener.png') no-repeat center center/cover;
            z-index: -1;
        }

        .hero-section h1 {
            font-size: 32px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin-top: 60px;
        }

        .hero-section .search-bar {
            display: inline-block;
            width: 80%;
            max-width: 600px;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 30px;
            background-color: white;
            margin-top: 30px;
        }

        .hero-section .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="#" class="logo">
                <img src="\images\LOGO.png" alt="Кошик" width="115" height="60">
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
                                <a href="/public/favorites.php" class="dropdown-toggle" title="Перехід до збережених рецептів" id="openFavoritesPage">
                                    <img src="/svg/2.svg" width="40" height="30">
                                </a>
                                <a href="#" class="dropdown-toggle" title="Перехід до профілю користувача" id="openUserPage">
                                    <img src="/svg/1.svg" width="40" height="30">
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

    <div class="hero-section">
        <h1>Заряджайте своє тіло та душу – знаходьте рецепти, що неймовірно смакують!</h1>
        <div class="search-bar">
            <input type="text" placeholder="Пошук за стравою, інгредієнтами...">
        </div>
        <div class="darkener-overlay"></div>
    </div>

    <main>
        <p>Ласкаво просимо на сайт!</p>
        <ul>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
            <li>
                <a href="public/category.php?id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Категорій не знайдено.</p>
    <?php endif; ?>
</ul>
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
