<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales - Редагувати профіль</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; 
            color: #000000;
            overflow-y: auto;
            height: 100vh;
            margin: 0;
            zoom: 1.1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
        }

        html, body {
            height: 100%;
        }

        .content-wrapper {
            display: flex;
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
            gap: 0;
            min-height: calc(100vh - 120px);
        }

        .main-content {
            flex: 1;
            background: white;
            padding: 30px;
            overflow-y: auto;
            height: calc(100vh - 120px);
        }

        h1 {
            text-align: center;
            margin-top: 40px;
            font-size: 25px;
            color: #000000;
        }

        main {
            flex: 1;
        }

    </style>
</head>
<body>
  <header>
    <div class="navbar">
      <a href="/" class="logo">
        <img src="/images/LOGO.png" alt="Кошик" width="115" height="60">
      </a>
      <nav class="main-nav">
        <a href="/" class="main-nav-link">Рецепти</a>
        <a href="#" class="main-nav-link">Інгредієнти</a>
        <a href="#" class="main-nav-link">Страви</a>
      </nav>
      <div class="right-nav">
        <div class="nav-icons">
          <div class="dropdown">
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
        </div>
      </div>
    </div>
  </header>
    <main>
    <h1>Улюблені рецепти</h1>
        <?php if (!empty($favorites)): ?>
            <ul>
                <?php foreach ($favorites as $recipe): ?>
                    <li>
                        <h2><?= htmlspecialchars($recipe['name']); ?></h2>
                        <img src="<?= htmlspecialchars($recipe['photo']); ?>" alt="<?= htmlspecialchars($recipe['name']); ?>" style="max-width: 200px;">
                        <p><?= htmlspecialchars($recipe['description']); ?></p>
                        <form action="favorites.php" method="POST">
                            <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                            <button type="submit" name="remove_favorite">Видалити</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>У вас ще немає улюблених рецептів.</p>
        <?php endif; ?>
    </main>

  <footer>
    <p>&copy; 2024 Kitchen Tales. Всі права захищені.</p>
  </footer>
</body>
</html>
