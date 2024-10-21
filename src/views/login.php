<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід | Kitchen Tales</title>
    <link rel="stylesheet" href="/public/CSS/style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> <!-- Шрифт -->
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="image-side">
                <img src="/images/pancakes.jpg" alt="Pancakes">
            </div>
            <div class="form-side">
                <div class="login-box">
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

                        <button type="submit" class="login-btn">Увійти</button>
                    </form>

                    <p class="signup-link">Не маєте акаунту? <a href="#">Зареєструватися</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
