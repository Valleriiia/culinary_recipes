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
            return 'Ви успішно увійшли, ' . $user['name'] . '!';
        } else {
            return 'Неправильний email або пароль!';
        }
    }
}
?>
