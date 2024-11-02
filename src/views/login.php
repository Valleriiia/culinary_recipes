<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Andev web - Перевірка форми</title>
    <link rel="stylesheet" href="/public/css/style.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>
<body>
    <div class="container" id="container">
        <div class="form-container register-container">
            <form id="register-form" method="POST" action="/public/login.php"> 
                <h1>Реєстрація</h1>
                <div class="form-control">
                    <input type="text" id="username" name="username" placeholder="Ім'я" required />
                </div>
                <div class="form-control">
                    <input type="email" id="register-email" name="email" placeholder="Електронна пошта" required />
                </div>
                <div class="form-control">
                    <input type="password" id="register-password" name="password" placeholder="Пароль" required />
                </div>
                <button type="submit" name="register">Зареєструватись</button>
            </form>
        </div>

        <div class="form-container login-container">
            <form id="login-form" method="POST" action="/public/login.php">
                <h1>Вхід</h1>
                <div class="form-control">
                    <input type="email" name="email" placeholder="Електронна пошта" required />
                </div>
                <div class="form-control">
                    <input type="password" name="password" placeholder="Пароль" required />
                </div>
                <button type="submit" name="login" class="login-button">Увійти</button>

                <div class="social-container">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                </div>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">Час готувати шедеври!</h1>
                    <p>Якщо у вас є обліковий запис, увійдіть сюди та діліться своїми рецептами!</p>
                    <button class="ghost" id="login">
                        Увійти
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div class="overlay-panel overlay-right">
                    <h1 class="title">Спробуйте нові смаки та ідеї!</h1>
                    <p>Якщо у вас ще немає облікового запису, реєструйтесь та відкрийте для себе безліч смачних рецептів!</p>
                    <button class="ghost" id="register">
                        Зареєструватись
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/scripts.js"></script>
</body>
</html>
