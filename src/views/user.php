<!DOCTYPE html>
<html lang="uk">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kitchen Tales - Редагувати профіль</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/user.css">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
		integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

	<!-- Перевірка повідомлення та його відображення -->
	<?php if ($message): ?>
		<div class="message <?php echo $messageType; ?>" id="flash-message"><?= htmlspecialchars($message) ?></div>
	<?php endif; ?>

	<!-- Хедер з логотипом та навігацією -->
	<header>
        <div class="navbar">
            <a href="index.php" class="logo">
                <img src="../images/LOGO.png" alt="Кошик" height="90">
            </a>
            <div class="right-nav">
                <div class="nav-icons">
                     <div class="dropdown">
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
                    </div>
                </div>
            </div>
        </div>
    </header>


	<!-- Основний вміст -->
	<div class="content-wrapper">
		<aside class="sidebar">
			<h2 class="menu-title">Мій профіль</h2>
			<ul class="profile-menu">
				<li class="active" data-tab="edit-profile">Редагувати профіль</li>
				<li data-tab="account-settings">Налаштування акаунту</li>
			</ul>
		</aside>

		<div class="main-content">
			<!-- Редагування профілю -->
			<div id="edit-profile" class="tab-content active">
				<h1 class="page-title">Редагувати профіль</h1>
				<div class="profile-form">
					<form action="../public/user.php" method="POST" enctype="multipart/form-data">
						<div class="form-section">
							<h2>Фото профілю</h2>
							<div class="photo-container">
								<img id="profile-photo" src="..<?php echo $profilePhotoUrl; ?>" alt="Фото профілю"
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
									<input type="text" id="new_username" name="new_username"
										value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" placeholder="Введіть новий нікнейм">
								</div>
							</div>
						</div>

						<div class="form-section">
							<button type="submit" name="update_profile" class="update-btn">Оновити</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Налаштування акаунту -->
			<div id="account-settings" class="tab-content">
				<h1 class="page-title">Налаштування акаунту</h1>
				<div class="profile-form">
					<form action="../public/user.php" method="POST">
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

	<!-- Скрипт для обробки фото профілю та вкладок -->
	<script>
		// Обробка натискання на іконку фото профілю
		document.querySelector('.camera-icon').addEventListener('click', function () {
			document.querySelector('#profile-photo-upload').click();
		});

		// Зміна фото профілю після вибору нового файлу
		document.querySelector('#profile-photo-upload').addEventListener('change', function (event) {
			const file = event.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function (e) {
					document.querySelector('#profile-photo').src = e.target.result;
				};
				reader.readAsDataURL(file);
			}
		});

		// Перемикання між вкладками
		document.querySelectorAll('.profile-menu li').forEach(item => {
			item.addEventListener('click', function (event) {
				event.preventDefault();
				const tabId = this.getAttribute('data-tab');
				document.querySelectorAll('.profile-menu li').forEach(li => li.classList.remove('active'));
				this.classList.add('active');
				document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
				document.getElementById(tabId).classList.add('active');
			});
		});

		// Обробка виходу з акаунту
		document.querySelector('#logout-link').addEventListener('click', function (event) {
			event.preventDefault();
			document.querySelector('#logout-form').submit();
		});

		// Перехід на інші сторінки
		document.getElementById('openUserPage').addEventListener('click', function (event) {
			event.preventDefault();
			window.location.href = 'user.php';
		});

		document.getElementById('openFavoritesPage').addEventListener('click', function (event) {
			event.preventDefault();
			window.location.href = 'favorites.php';
		});

		// Сховання повідомлення після 3 секунд
		document.addEventListener('DOMContentLoaded', () => {
			const flashMessage = document.getElementById('flash-message');
			if (flashMessage) {
				setTimeout(() => {
					flashMessage.classList.add('hide');
					setTimeout(() => flashMessage.remove(), 500);
				}, 2000);
			}
		});
	</script>

	<footer>
		<p>&copy; 2024 Kitchen Tales. Всі права захищені.</p>
	</footer>

</body>
</html>
