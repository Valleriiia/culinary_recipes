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
        try {
            $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($currentPassword, $user['password'])) {
                return 'Поточний пароль невірний.';
            }

            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateStmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$newHashedPassword, $userId]);

            return 'Пароль успішно змінено.';
        } catch (PDOException $e) {
            error_log('Помилка зміни паролю: ' . $e->getMessage());
            return 'Технічна помилка. Спробуйте пізніше.';
        }
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
    
        public function addRecipeToFavorites($userId, $recipeId) {
            $stmt = $this->pdo->prepare("INSERT IGNORE INTO favorites (id_user, id_recipe) VALUES (?, ?)");
            try {
                $stmt->execute([$userId, $recipeId]);
                return true;
            } catch (PDOException $e) {
                error_log('Помилка додавання рецепту в обране: ' . $e->getMessage());
                return false;
            }
        }

        public function removeRecipeFromFavorites($userId, $recipeId) {
            $query = "DELETE FROM favorites WHERE id_user = :user_id AND id_recipe = :recipe_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
            
            try {
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                error_log('Помилка видалення рецепту з обраного: ' . $e->getMessage());
                return false;
            }
        }
    
        public function isRecipeInFavorites($userId, $recipeId) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM favorites WHERE id_user = ? AND id_recipe = ?");
            $stmt->execute([$userId, $recipeId]);
            return $stmt->fetchColumn() > 0;
        }

        public function getFavoriteRecipes($userId) {
            $stmt = $this->pdo->prepare("
                SELECT r.* 
                FROM favorites f
                JOIN recipes r ON f.id_recipe = r.id
                WHERE f.id_user = ?
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
        
