<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #2F5333;
            --secondary-color: #f0f0f0;
            --text-color: #000000;
            --sidebar-color: #D7E0D8; 
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            overflow-y: auto; 
            height: 100vh;
            margin: 0;
            zoom: 1.1;
        }

        header {
            background: white;
            border-bottom: 1px solid #e5e5e5;
            padding: 5px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--text-color);
            font-weight: bold;
            font-size: 20px;
            padding-left: 50px;
        }
        .main-nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .main-nav a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .main-nav a:hover {
            color: var(--primary-color);
        }

        .right-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-icons {
            display: flex;
            gap: 25px;
            padding-right: 50px;
        }


        .nav-icons a {
            color: var(--text-color);
            font-size: 20px;
            margin-right: 5px;
        }
        .dropdown {
    display: inline-block;
    position: relative;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: white; 
    min-width: 130px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1;
    right: 0;
    border-radius: 4px;
    padding: 8px 0;
}

.dropdown-menu a {
    color: black; 
    padding: 8px 16px;
    text-decoration: none;
    display: block;
    font-size: 14px;
}

.dropdown-menu a:hover {
    background-color: #f0f0f0; 
}

.dropdown:hover .dropdown-menu {
    display: block;
}

        footer {
            background: #2F5333;
            color: white;
            text-align: center;
            padding: 15px 0;
            width: 100%;
        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            transition: text-decoration 0.3s ease;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: var(--primary-color);
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

        html {
    scrollbar-width: thin;
    scrollbar-color: #999 #f7fafc;
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
                                <a href="#" class="dropdown-toggle" title="Перехід до збережених рецептів" id="openFavoritesPage">
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