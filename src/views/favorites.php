<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tales - Улюблені рецепти</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&display=swap');
        html, body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

footer {
    background: #2F5333;
    color: white;
    text-align: center;
    padding: 15px 0;
    width: 100%;
    margin-top: 13px;
    position: relative;
    bottom: 0;
}

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

        .rating {
            display: flex;
            gap: 5px;
        }

        .star {
            width: 24px;
            height: 24px;
            background: lightgray;
            -webkit-mask: url('../../svg/Star.svg') no-repeat center;
            mask: url('../../svg/Star.svg') no-repeat center;
            -webkit-mask-size: contain;
            mask-size: contain;
        }

        .star.filled {
            background: #407948;
        }

        .star.half {
            background: linear-gradient(90deg, #407948 50%, lightgray 50%);
        }

        .rating span {
            vertical-align: text-bottom;
            font-size: 18px;
            margin-top: 3px;
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
                                <?php 
                                $rating = $userController->getRecipeRating($recipe['id']);
                                $averageRating = $rating['average'];
                                $ratingCount = $rating['count'];

                                for ($i = 1; $i <= 5; $i++): 
                                    $fillPercentage = 0;
                                    if ($averageRating >= $i) {
                                        $fillPercentage = 100;
                                    } elseif ($averageRating >= $i - 0.5) {
                                        $fillPercentage = 50;
                                    } else {
                                        $fillPercentage = 0;
                                    }
                                ?>
                                    <div class="star" style="background: linear-gradient(90deg, #407948 <?= $fillPercentage; ?>%, lightgray <?= (100 - $fillPercentage); ?>%);"></div>
                                <?php endfor; ?>
                                <span>(<?= htmlspecialchars($ratingCount); ?>)</span>
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
        document.querySelector('#logout-link').addEventListener('click', function (event) {
        event.preventDefault();
        document.querySelector('#logout-form').submit();
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
</body>
</html>
