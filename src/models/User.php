<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if (password_get_info($user['password'])['algo']) {
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            } else {
                if ($password === $user['password']) {
                    return $user;
                }
            }
        }
        return false;
    }

    public function register($name, $email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return 'Користувач з таким email вже існує.';
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $hashedPassword]);
            return 'Реєстрація успішна! Ви можете увійти на сайт.';
        } catch (PDOException $e) {
            error_log('Помилка реєстрації: ' . $e->getMessage());
            return 'Помилка реєстрації. Спробуйте пізніше.';
        }
    }

    public function updateProfile($userId, $name, $profilePhoto = null) {
        try {
            if ($profilePhoto) {
                $stmt = $this->pdo->prepare("UPDATE users SET name = ?, profile_photo = ? WHERE id = ?");
                $stmt->execute([$name, $profilePhoto, $userId]);
            } else {
                $stmt = $this->pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
                $stmt->execute([$name, $userId]);
            }
            return true;
        } catch (PDOException $e) {
            error_log('Помилка оновлення профілю: ' . $e->getMessage());
            return false;
        }
    }

    public function changePassword($userId, $currentPassword, $newPassword) {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            if (password_get_info($user['password'])['algo']) {
                if (password_verify($currentPassword, $user['password'])) {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateStmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $updateStmt->execute([$hashedNewPassword, $userId]);
                    return "Пароль успішно змінено.";
                }
            } 
            else {
                if ($currentPassword === $user['password']) {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateStmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $updateStmt->execute([$hashedNewPassword, $userId]);
                    return "Пароль успішно змінено.";
                }
            }
        }
        return "Неправильний поточний пароль.";
    }
    
    public function getUserProfile($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT profile_photo FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user['profile_photo'] ?? '/images/default_profile.png';
        } catch (PDOException $e) {
            error_log('Помилка отримання профілю: ' . $e->getMessage());
            return '/images/default_profile.png';
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
    public function addToFavorites($userId, $recipeId) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO favorites (id_user, id_recipe) VALUES (?, ?)");
            $stmt->execute([$userId, $recipeId]);
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return false;
            }
            error_log('Помилка додавання в обрані: ' . $e->getMessage());
            return false;
        }
    }
    
    public function removeFromFavorites($userId, $recipeId) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM favorites WHERE id_user = ? AND id_recipe = ?");
            $stmt->execute([$userId, $recipeId]);
            return true;
        } catch (PDOException $e) {
            error_log('Помилка видалення з обраних: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getFavoriteRecipes($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT r.id, r.name, r.photo, r.cooking_time, r.rating 
                FROM recipes r
                JOIN favorites f ON r.id = f.id_recipe
                WHERE f.id_user = ?
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Помилка отримання обраних рецептів: ' . $e->getMessage());
            return [];
        }
    }
    
    public function isRecipeInFavorites($userId, $recipeId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM favorites 
                WHERE id_user = ? AND id_recipe = ?
            ");
            $stmt->execute([$userId, $recipeId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Помилка перевірки обраних рецептів: ' . $e->getMessage());
            return false;
        }
    }

    public function getRecipeRating($recipeId) {
        $stmt = $this->pdo->prepare("SELECT AVG(rating) as average, COUNT(rating) as count FROM reviews WHERE id_recipe = ?");
        $stmt->execute([$recipeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
