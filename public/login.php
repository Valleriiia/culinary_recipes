<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

$userController = new UserController($pdo);

$message = '';

if (!empty($_POST)) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($email) || empty($password)) {
        $message = 'Будь ласка, заповніть всі поля.';
    } else {
        $message = $userController->login($email, $password);
        
        if (strpos($message, 'успішно') !== false) {
            header('Location: user.php');
            exit;
        }
    }
}

include '../src/views/login.php';
?>
