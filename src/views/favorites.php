<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales - Улюблені рецепти</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&display=swap');
        
        .recipes-list {
            display: flex;
            flex-wrap: wrap;
        }

        li {
            margin-left: 40px;
            list-style-type: none;
            margin-bottom: 48px;
        }

        .recipes-list a {
            text-decoration: none;
        }

        .recipes-list a:visited {
            color: var(--text-color);
        }

        .recipes-list a:hover {
            color: var(--primary-color);
        }

        h1 {
            text-align: center;
            margin-top: 35px; 
            margin-bottom: 50px; 
            font-family: "Cormorant Garamond", serif;
            font-size: 46px; 
        }

        .image-container {
            width: 404px;
            height: 290px;
            background-size: cover !important;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
            text-align: end;
            padding: 14px;
        }

        .image-container {
            position: relative;
        }

        h4 {
            font-size: 28px;
            font-weight: 500;
            line-height: 42px;
            margin-bottom: 5px;
        }

        .recipes-list p {
            font-size: 18px;
            font-weight: 300;
            line-height: 27px;
            margin-bottom: 6px;
        }

        .rating {
            display: flex;
            gap: 5px;
        }

        .star {
            width: 24px;
            height: 24px;
            -webkit-mask: url('../../svg/Star.svg') no-repeat center;
            mask: url('../../svg/Star.svg') no-repeat center;
            -webkit-mask-size: contain;
            mask-size: contain;
            background: lightgray;
        }

        .star.filled {
            background: gold;
        }

        .not-found {
            font-size: 30px;
            text-align: center;
        }


        section {
            display: flex;
            justify-content: space-between;
            align-items: center; 
            width: 100%;
            padding: 10px 0;
        }


        .remove-favorite-icon {
            width: 60px;
            height: 60px;
            position: relative;
            top: -295px; 
            left: 340px; 
            cursor: pointer;
            z-index: 10; 
        }

        .recipe-details {
            flex: 1;
            margin-top: -75px; 
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
            <ul class="recipes-list">
                <?php foreach ($favorites as $recipe): ?>
                  <li>
                    <a href="../public/recipe.php?id=<?= $recipe['id']; ?>">
                        <div class="image-container" style="background: linear-gradient(179.91deg, #1D1D1D -43.99%, rgba(29, 29, 29, 0) 23.35%), url('../images/<?php echo htmlspecialchars($recipe['photo']) ?>');">
                        </div>

                        <section>
                        <form action="favorites.php" method="POST" class="favorite-form">
                            <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                            <img src="../svg/6.svg" alt="Видалити рецепт" class="remove-favorite-icon" title="Видалити рецепт" style="cursor: pointer;">
                        </form>

                        <div class="recipe-details">
                            <h4><?= htmlspecialchars($recipe['name']); ?></h4>
                            <p class="cooking-time">Час приготування: <?= $recipe['cooking_time']; ?> хв</p>
                            <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                  <?php $fillPercentage = ($ratings[$recipe['id']]['average'] >= $i) ? 100 : 0; ?>
                                       <div class="star" style="background: linear-gradient(90deg, #407948 <?php echo $fillPercentage; ?>%, lightgray <?php echo (100 - $fillPercentage); ?>%);"></div>
                                    <?php endfor; ?>
                                <p>(<?= htmlspecialchars($ratings[$recipe['id']]['count']); ?>)</p>
                            </div>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="not-found">У вас ще немає улюблених рецептів.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Kitchen Tales. Всі права захищені.</p>
    </footer>

    <script>
        const stars = document.querySelectorAll('.rating .star');
        const ratingInput = document.getElementById('rating');

        stars.forEach((star) => {
            star.addEventListener('click', () => {
                const value = star.dataset.value;
                ratingInput.value = value;

                stars.forEach(s => s.classList.remove('selected'));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }
            });

            star.addEventListener('mouseover', () => {
                stars.forEach(s => s.classList.remove('hover'));
                for (let i = 0; i < star.dataset.value; i++) {
                    stars[i].classList.add('hover');
                }
            });

            star.addEventListener('mouseout', () => {
                stars.forEach(s => s.classList.remove('hover'));
            });
        });
        document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            const form = this.closest('form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                if (data.success) {
                    form.closest('li').remove();
                } else {
                    alert('Сталася помилка при видаленні рецепту.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
         document.querySelectorAll('.remove-favorite-icon').forEach(icon => {
        icon.addEventListener('click', function (event) {
            event.preventDefault(); 

            const recipeId = this.closest('form').querySelector('input[name="recipe_id"]').value;
            const formData = new FormData();
            formData.append('recipe_id', recipeId);
            formData.append('remove_favorite', true);


            fetch('favorites.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                if (data.success) {
                    this.closest('li').remove();
                } else {
                    alert('Сталася помилка при видаленні рецепту: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Сталася помилка.');
            });
        });
    });
    </script>
    <script src="/js/scripts.js"></script>
</body>
</html>
