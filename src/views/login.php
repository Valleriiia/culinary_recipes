<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід | Kitchen Tales</title>
    <link rel="stylesheet" href="/public/CSS/style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> <!-- Шрифт -->
    <script>
        function showRegistration() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="image-side">
                <img src="/images/pancakes.jpg" alt="Pancakes" style="width: 100%; height: 100%; object-fit: cover;"> <!-- Відновлення зображення -->
            </div>
            <div class="form-side">
                <div class="login-box">

                    <div id="login-form">
                        <h1 class="login-title">Вхід</h1>

                        <?php if (!empty($message)): ?>
                            <p><?php echo htmlspecialchars($message); ?></p>
                        <?php endif; ?>

                        <div class="social-login">
                            <button class="social-btn facebook-btn">
                                <img src="/public/images/facebook-icon.png" alt="Facebook"> Увійти через Facebook
                            </button>
                            <button class="social-btn google-btn">
                                <img src="/public/images/google-icon.png" alt="Google"> Увійти через Google
                            </button>
                        </div>

                        <div class="separator">
                            <span>АБО</span>
                        </div>

                        <form method="post" action="">
                            <div class="input-group">
                                <label for="email">E-mail адреса</label>
                                <input type="email" id="email" name="email" placeholder="Введіть свій e-mail" required>
                            </div>

                            <div class="input-group">
                                <label for="password">Пароль</label>
                                <input type="password" id="password" name="password" placeholder="Введіть пароль" required>
                            </div>

                            <button type="submit" name="login" class="login-btn">Увійти</button>
                        </form>

                        <p class="signup-link">Не маєте акаунту? <a href="javascript:void(0);" onclick="showRegistration()">Зареєструватися</a></p>
                    </div>

                    <div id="register-form" style="display:none;">
                        <h1 class="login-title">Реєстрація</h1>

                        <div class="social-login">
                            <button class="social-btn facebook-btn">
                                <img src="/public/images/facebook-icon.png" alt="Facebook"> Зареєструватися через Facebook
                            </button>
                            <button class="social-btn google-btn">
                                <img src="/public/images/google-icon.png" alt="Google"> Зареєструватися через Google
                            </button>
                        </div>

                        <div class="separator">
                            <span>АБО</span>
                        </div>

                        <form method="post" action="">
                            <div class="input-group">
                                <label for="username">Ім'я користувача</label>
                                <input type="text" id="username" name="username" placeholder="Введіть ваше ім'я" required>
                            </div>

                            <div class="input-group">
                                <label for="email">E-mail адреса</label>
                                <input type="email" id="email" name="email" placeholder="Введіть свій e-mail" required>
                            </div>

                            <div class="input-group">
                                <label for="password">Пароль</label>
                                <input type="password" id="password" name="password" placeholder="Введіть пароль" required>
                            </div>

                            <button type="submit" name="register" class="login-btn">Зареєструватися</button>
                        </form>

                        <p class="signup-link">Вже маєте акаунт? <a href="javascript:void(0);" onclick="showLogin()">Увійти</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
