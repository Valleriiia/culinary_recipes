<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales - Редагувати профіль</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
      body {
          font-family: Arial, sans-serif;
          background-color: #f0f0f0;
          color: #000000;
          overflow-y: auto;
          height: 100vh;
          margin: 0;
          zoom: 1.1;
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
          color: #000000;
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
          background: #D7E0D8;
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
          color: #000000;
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
          color: #000000;
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
          color: #000000;
      }

      .profile-photo-section {
          margin-bottom: 40px;
      }

      .profile-photo-section h2 {
          font-size: 18px;
          margin-bottom: 20px;
          color: #000000;
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
          color: #000000;
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
          color: #000000;
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

      .tab-content {
          display: none;
      }

      .tab-content.active {
          display: block;
      }

    </style>
</head>
<body>
  <header>
    <div class="navbar">
        <a href="/" class="logo">
            <img src="\images\LOGO.png" alt="Кошик" width="115" height="60">
        </a>
        <nav class="main-nav">
            <a href="../" class="main-nav-link">Рецепти</a>
            <a href="#" class="main-nav-link">Інгредієнти</a>
            <a href="#" class="main-nav-link">Страви</a>
        </nav>
        <div class="right-nav">
            <div class="nav-icons">
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" title="Перехід до збережених рецептів" id="openUserPage">
        <a href="/public/favorites.php" class="dropdown-toggle" title="Перехід до збережених рецептів" id="openFavoritesPage">
                                    <img src="/svg/2.svg" width="40" height="30">
                                </a>
            <img src="\svg\1.svg" width="40" height="30">
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
          </div>
        </div>
        <form id="logout-form" action="/public/user.php" method="POST" style="display: none;">
          <input type="hidden" name="logout" value="true">
        </form>
      </div>
    </div>
  </header>

  <div class="content-wrapper">
    <aside class="sidebar">
      <h2 class="menu-title">Мій профіль</h2>
      <ul class="profile-menu">
        <li class="active" data-tab="edit-profile">Редагувати профіль</li>
        <li data-tab="account-settings">Налаштування акаунту</li>
      </ul>
    </aside>
    <div class="main-content">
      <div id="edit-profile" class="tab-content active">
        <h1 class="page-title">Редагувати профіль</h1>
        <div class="profile-form">
          <form action="/public/user.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
              <h2>Фото профілю</h2>
              <div class="photo-container">
                <img id="profile-photo" src="<?php echo $profilePhotoUrl; ?>" alt="Фото профілю"
                  style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <div class="camera-icon">
                  <i class="fas fa-camera"></i>
                </div>
              </div>
              <input type="file" id="profile-photo-upload" name="profile_photo" accept="image/*" style="display: none;">
            </div>
            <div class="form-section">
              <h2>Основні дані</h2>
              <div class="form-row">
                <div class="form-group">
                  <label for="new_username">Нікнейм</label>
                  <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>"
                    placeholder="Введіть новий нікнейм">
                </div>
              </div>
            </div>
            <div class="form-section">
              <button type="submit" name="update_profile" class="update-btn">Оновити</button>
            </div>
          </form>
        </div>
      </div>
      <div id="account-settings" class="tab-content">
        <h1 class="page-title">Налаштування акаунту</h1>
        <div class="profile-form">
          <form action="/public/user.php" method="POST">
            <div class="form-section">
              <h2>Зміна паролю</h2>
              <div class="form-row">
                <div class="form-group">
                  <label for="current_password">Поточний пароль</label>
                  <input type="password" id="current_password" name="current_password" placeholder="Введіть поточний пароль" required>
                </div>
                <div class="form-group">
                  <label for="new_password">Новий пароль</label>
                  <input type="password" id="new_password" name="new_password" placeholder="Введіть новий пароль" required>
                </div>
                <div class="form-group">
                  <label for="confirm_password">Підтвердження паролю</label>
                  <input type="password" id="confirm_password" name="confirm_password" placeholder="Підтвердіть новий пароль" required>
                </div>
              </div>
            </div>
            <div class="form-section">
              <button type="submit" name="change_password" class="update-btn">Змінити пароль</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('.camera-icon').addEventListener('click', function() {
      document.querySelector('#profile-photo-upload').click();
    });

    document.querySelector('#profile-photo-upload').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.querySelector('#profile-photo').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    document.querySelectorAll('.profile-menu li').forEach(item => {
      item.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        document.querySelectorAll('.profile-menu li').forEach(li => {
          li.classList.remove('active');
        });
        this.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(tab => {
          tab.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');
      });
    });

    document.querySelector('#logout-link').addEventListener('click', function(event) {
      event.preventDefault();
      document.querySelector('#logout-form').submit();
    });

    document.getElementById('openUserPage').addEventListener('click', function(event) {
      event.preventDefault();
      window.location.href = 'user.php';
    });

    document.getElementById('openFavoritesPage').addEventListener('click', function(event) {
      event.preventDefault();
      window.location.href = 'favorites.php';
    });
  </script>

  <footer>
    <p>&copy; 2024 Kitchen Tales. Всі права захищені.</p>
  </footer>
</body>
