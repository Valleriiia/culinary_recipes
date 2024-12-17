<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales - Редагувати профіль</title>
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

        .sub-menu {
            background: white;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
            gap: 30px;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 79px; 
            z-index: 99;
        }

        .sub-menu a {
            color: var(--text-color);
            text-decoration: none;
            font-size: 14px;
        }

        .content-wrapper {
            display: flex;
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
            gap: 0;
            min-height: calc(100vh - 120px);
        }

        .sidebar {
            width: 250px;
            background: var(--sidebar-color);
            padding: 20px;
            color: #2C3E50;
            position: sticky;
            top: 120px; 
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            background: white;
            padding: 30px;
            overflow-y: auto;
            height: calc(100vh - 120px);
        }

        .menu-title {
            font-size: 22px;
            font-weight: bold;
            color: var(--text-color);
            margin-bottom: 15px;
            margin-top: 18px; 
        }

        .profile-menu {
            list-style: none;
        }

        .profile-menu li {
            padding: 12px;
            margin-bottom: 5px;
            cursor: pointer;
            color: black;
            margin-top: -5; 
            margin-left: -20px;
            padding-left: 20px;
            width: calc(100% + 40px);
        }
        .profile-menu li.active {
            background: white;
            color: var(--text-color);
            font-weight: 500;
            border-radius: 0;
            margin-left: -20px;
            padding-left: 20px;
            width: calc(100% + 40px);
        }

        .profile-menu li:hover {
            background: #778B7A;
        }

        .page-title {
            font-size: 28px;
            margin-bottom: 30px;
            color: var(--text-color);
        }

        .profile-photo-section {
            margin-bottom: 40px;
        }

        .profile-photo-section h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .photo-container {
            width: 100px;
            height: 100px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            position: relative;
        }

        .photo-container i {
            font-size: 24px;
            color: #666;
        }

        .camera-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            padding: 8px;
        }

        .profile-form {
            max-width: 600px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .update-btn {
            background-color: #2F5333; 
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 20px; 
            cursor: pointer;
            font-weight: 500;
            font-size: 16px; 
            display: inline-block;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        .update-btn:hover {
            background-color: #345d41; 
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
        }

        footer a:hover {
            text-decoration: underline;
        }

        html {
            scroll-behavior: smooth;
        }

        .sidebar, .main-content {
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) var(--secondary-color);
        }

        .sidebar::-webkit-scrollbar,
        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb,
        .main-content::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-track,
        .main-content::-webkit-scrollbar-track {
            background-color: var(--secondary-color);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
        .nav-icons {
        position: relative;
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
.nav-icons a {
    text-decoration: none; 
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
              <a href="#" class="dropdown-item">Мій профіль</a>
              <a href="#" class="dropdown-item" id="logout-link">Вийти</a>
            </div>
          </div>
        </div>
        <form id="logout-form" action="/public/user.php" method="POST" style="display: none;">
          <input type="hidden" name="logout" value="true">
        </form>
      </div>
    </div>
  </header>
  </head>
    <h1>Мої улюблені рецепти</h1>

    <?php if (!empty($favorites)): ?>
        <div class="favorites-list">
            <?php foreach ($favorites as $favorite): ?>
                <div class="favorite-recipe">
                    <h3><?= htmlspecialchars($favorite['name']); ?></h3>
                    <p><?= htmlspecialchars($favorite['description']); ?></p>
                    <img src="<?= htmlspecialchars($favorite['photo']); ?>" alt="<?= htmlspecialchars($favorite['name']); ?>" class="recipe-photo">
                    
                    <form action="favorites.php" method="POST">
                        <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($favorite['id']); ?>">
                        <button type="submit" name="remove_from_favorites">Видалити з вибраного</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>У вас немає вибраних рецептів.</p>
    <?php endif; ?>
  </div>

  <footer>
    <p>&copy; 2024 Kitchen Tales. Всі права захищені.</p>
  </footer>
</body>
</html>
