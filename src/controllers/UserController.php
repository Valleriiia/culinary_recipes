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
            $_SESSION['user_name'] = $user['name'];  
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
        header('Location: login.php'); 
        exit();
    }
}
?>
