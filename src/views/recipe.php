<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/recipes.css">
    <script>
        // Передаємо змінну з PHP до JS
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    </script>
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
                            <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
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
                        <?php else: ?>
                            <form action="../public/login.php" method="get">
                                <button type="submit" class="login-btn">Вхід/Реєстрація</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- <div class="search">
            <form action="../public/search.php" method="GET">
                <input class="search-input" type="search" name="q" placeholder="Пошук рецептів">
                <button type="submit" hidden>Знайти</button>
            </form>
        </div> -->
        <h1><?= htmlspecialchars($recipe['name']); ?></h1>
        <div class="rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php $fillPercentage = max(0, min(100, ($ratings['average'] - $i + 1) * 100)); ?>
                <div class="star" style="background: linear-gradient(90deg, #407948 <?php echo $fillPercentage; ?>%, #ADB9AE <?php echo (100 - $fillPercentage); ?>%);"></div>
            <?php endfor; ?>
            <p> <?= htmlspecialchars($ratings['average']); ?></p>
            <p> (<?= htmlspecialchars($ratings['count']); ?>)</p>
        </div>
        <p class="date"><?= htmlspecialchars($recipe['only_date']) ?></p>
        <img class="recipe-picture" src="../images/<?= htmlspecialchars($recipe['photo']); ?>" alt=<?= htmlspecialchars($recipe['name']); ?>>
        <div class="buttons-container">
            <form id="favorite-form-<?= $recipe['id']; ?>" action="update_favorites.php" method="POST" onsubmit="return false;">
                <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                <button class="<?= $isRecipeAdded ? "save-button" : "save-button-selected" ?>" type="button" name="add_favorite" onclick="toggleFavoriteIcon(this, <?= $recipe['id']; ?>)">
                    <img src="../svg/7.svg" alt="save-button"> ЗБЕРЕГТИ
                </button>
            </form>
            <a href="#review" class="rating-link">
                <img src="../svg/8.svg" alt="to-rate-button"> РЕЙТИНГ
            </a>
        </div>
        <p class="description"><?= htmlspecialchars($recipe['description']); ?></p>
        <div class="recipe-info">
            <div class="info-block">
                <img src="../images/cook-book.png" alt="Складність піктограма">
                <p>Складність</p>
                <p><?= htmlspecialchars($recipe['complexity']); ?></p>
            </div>
            <div class="hr"></div>
            <div class="info-block">
                <img src="../images/cooking-time.png" alt="Час приготування піктограма">
                <p>Час приготування</p>
                <p><?= htmlspecialchars($recipe['cooking_time']); ?> хвилин</p>
            </div>
        </div>

        <h3>Інгредієнти:</h3>
        <ul class="ingredients">
            <?php foreach ($ingredients as $ingredient): ?>
                <li class="ingredient"> <?= htmlspecialchars($ingredient['name']); ?> <?=htmlspecialchars($ingredient['quantity']); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Інструкція:</h3>
        <div class="instruction"><?= $recipe['instructions']; ?></div>


        <section id="review">
            <div class="add-review">
                <h3>Відгуки (<?= htmlspecialchars($ratings['count']); ?>)</h3>
                <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php $fillPercentage = max(0, min(100, ($ratings['average'] - $i + 1) * 100)); ?>
                        <div class="star" style="background: linear-gradient(90deg, #407948 <?php echo $fillPercentage; ?>%, #ADB9AE <?php echo (100 - $fillPercentage); ?>%);"></div>
                    <?php endfor; ?>
                    <p> <?= htmlspecialchars($ratings['average']); ?></p>
                </div>
                <form id="review-form" class="review-form" action="../public/add_review.php" method="POST">
                    <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                    <img src="..<?= htmlspecialchars($user_photo ?? "/images/default_profile.png") ; ?>" alt="profile_photo">
                    <div class="add">
                        <label for="rating">Ваша оцінка:<span>(обов'язково)</span></label>
                        <div class="enter-rating">
                            <span class="enter-star" data-value="1">&#9733;</span>
                            <span class="enter-star" data-value="2">&#9733;</span>
                            <span class="enter-star" data-value="3">&#9733;</span>
                            <span class="enter-star" data-value="4">&#9733;</span>
                            <span class="enter-star" data-value="5">&#9733;</span>
                        </div>
                        <input type="hidden" name="rating" id="enter-rating" value="0" required>

                        <label for="comment">Ваш відгук:<span>(необов'язково)</span></label> <br/>
                        <textarea class="comment" name="comment" placeholder="Поділіться своєю любов'ю! Розкажіть нам, що ви думаєте про рецепт, у короткому відгуку."></textarea>
                        <div class="button-block">
                            <button type="submit" class="add-review-button">Додати відгук</button>
                        </div>
                    </div>
                </form>
                <div id="review-message" style="display: none;"></div>
            </div>
            <div class="reviews-list">
                <?php if (!empty($reviews)): ?>
                    <ul>
                        <?php foreach ($reviews as $review): ?>
                            <li class="review-container">
                                <img src="..<?= htmlspecialchars($review['profile_photo']); ?>" alt="profile_photo">
                                <div class="review">
                                    <p class="user-name"><?= htmlspecialchars($review['name']); ?></p>
                                    <div class="rating">
                                        <?= str_repeat('<div class="star" style="background: #407948"></div>', $review['rating']) . str_repeat('<div class="star" style="background: #ADB9AE"></div>', 5 - $review['rating']); ?>
                                        <p class="review-date"><?= $review['only_date']; ?></p>
                                    </div>
                                    <p class="review-text"><?= htmlspecialchars($review['text'] ?? ''); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-reviews">Відгуків ще немає.</p>
                <?php endif; ?>
            </div>
        </section>

        
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Ваш кулінарний сайт</p>
    </footer>
    <script>
       

    const stars = document.querySelectorAll('.enter-rating .enter-star');
    const ratingInput = document.getElementById('enter-rating');

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

    document.getElementById('review-form').addEventListener('submit', function (e) {
    e.preventDefault(); // Зупиняємо стандартну поведінку відправки форми
    
    const form = e.target;
    const formData = new FormData(form);
    const messageBox = document.getElementById('review-message');
    const reviewsList = document.querySelector('.reviews-list ul');

    if (!isLoggedIn) {
            alert("Ви не ввійшли у свій акаунт!");
            return;
        }


    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageBox.style.display = 'block';
            messageBox.style.color = 'green';
            messageBox.textContent = 'Ваш відгук успішно додано!';
            form.reset();

            const review = data.review;
            const newReviewHTML = `
                <li class="review-container">
                    <img src="..${review.profile_photo}" alt="profile_photo">
                    <div class="review">
                        <p class="user-name">${review.name}</p>
                        <div class="rating">
                            ${'<div class="star" style="background: #407948"></div>'.repeat(review.rating)}
                            ${'<div class="star" style="background: #ADB9AE"></div>'.repeat(5 - review.rating)}
                            <p class="review-date">${review.only_date}</p>
                        </div>
                        <p class="review-text">${review.text || ''}</p>
                    </div>
                </li>
            `;

            if (reviewsList) {
                reviewsList.insertAdjacentHTML('afterbegin', newReviewHTML);
                location.reload();
            } else {
                const noReviewsText = document.querySelector('.no-reviews');
                if (noReviewsText) {
                    noReviewsText.remove();
                }
                const newList = document.createElement('ul');
                newList.innerHTML = newReviewHTML;
                document.querySelector('.reviews-list').appendChild(newList);
                location.reload();
            }
        } else {
            messageBox.style.display = 'block';
            messageBox.style.color = 'red';
            messageBox.textContent = data.error || 'Виникла помилка. Спробуйте ще раз.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload();
    });
});



document.querySelector('#logout-link').addEventListener('click', function(e) {
        e.preventDefault();  
        document.querySelector('#logout-form').submit();  
    });

</script>
</body>
</html>