<?php
require_once __DIR__ . '/../../config/database.php'; 
require_once __DIR__ . '/../models/User.php'; 

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function login($email, $password) {
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            $_SESSION['user_name'] = htmlspecialchars($user['name']);  
            $_SESSION['user_id'] = $user['id']; 
            return 'Ви успішно увійшли, ' . htmlspecialchars($user['name']) . '!';
        } else {
            return 'Невірний email або пароль!';
        }
    }

    public function register($name, $email, $password) {
        if (empty($name) || empty($email) || empty($password)) {
            return 'Всі поля є обов\'язковими.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Невірний формат електронної пошти.';
        }
        return $this->userModel->register($name, $email, $password);
    }

    public function updateUserProfile($userId, $newUsername, $profilePhotoPath = null) {
        if (empty($newUsername)) {
            return "Ім'я користувача не може бути порожнім.";
        }
        $success = $this->userModel->updateProfile($userId, $newUsername, $profilePhotoPath);

        return $success ? "Профіль успішно оновлено!" : "Не вдалося оновити профіль.";
    }

    public function getUserProfile($userId) {
        return $this->userModel->getUserProfile($userId);
    }

    public function changeUserPassword($userId, $currentPassword, $newPassword) {
        return $this->userModel->changePassword($userId, $currentPassword, $newPassword);
        
    }
    
    public function addToFavorites($userId, $recipeId) {
        return $this->userModel->addToFavorites($userId, $recipeId);
    }

    public function removeFromFavorites($userId, $recipeId) {
        return $this->userModel->removeFromFavorites($userId, $recipeId);
    }

    public function getFavoriteRecipes($userId) {
        return $this->userModel->getFavoriteRecipes($userId);
    }

    public function isRecipeInFavorites($userId, $recipeId) {
        return $this->userModel->isRecipeInFavorites($userId, $recipeId);
    }

    public function getRecipeRating($recipeId) {
        return $this->userModel->getRecipeRating($recipeId);
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
?>
