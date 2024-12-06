<?php

require_once __DIR__ . '/../../config/database.php'; 
require_once __DIR__ . '/../models/User.php'; 

class UserController {
    private $userModel;
    private $pdo;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->pdo = $pdo; 
    }

    public function login($email, $password) {
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            $_SESSION['user_name'] = $user['name'];  
            $_SESSION['user_id'] = $user['id']; 
            return 'Ви успішно увійшли, ' . htmlspecialchars($user['name']) . '!';
        } else {
            return 'Неправильний email або пароль!';
        }
    }

    public function register($name, $email, $password) {
        $message = $this->userModel->register($name, $email, $password);
        
        if ($message === 'Реєстрація успішна! Ви можете увійти на сайт.') {
            $_SESSION['user_name'] = $name; 
            return 'Ви успішно зареєструвалися, ' . htmlspecialchars($name) . '!';
        }
        return $message; 
    }

    public function logout() {
        $this->userModel->logout(); 
        header("Location:  index.php"); 
        exit;
    }

    public function changeUsername($userId, $newName) {
        if (empty($newName)) {
            return "Нікнейм не може бути порожнім.";
        }
        $message = $this->userModel->updateUsername($userId, $newName);
        if ($message === true) {
            $_SESSION['user_name'] = $newName;
            return "Нікнейм успішно змінено на $newName.";
        }
        return "Помилка зміни нікнейму.";
    }

    public function updateUserProfile($userId, $newUsername, $profilePhotoPath) {
        $query = "UPDATE users SET name = ?, profile_photo = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$newUsername, $profilePhotoPath, $userId]);
        
        return "Профіль успішно оновлено!";
    }

    public function getUserProfile($userId) {
        $stmt = $this->pdo->prepare("SELECT profile_photo FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['profile_photo'];
    }
    public function changeUserPassword($userId, $currentPassword, $newPassword) {
        if (empty($newPassword)) {
            return "Новий пароль не може бути порожнім.";
        }
        $message = $this->userModel->changePassword($userId, $currentPassword, $newPassword);
        return $message;
    }
    
}
?>