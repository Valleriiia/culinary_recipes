<?php
session_start(); 

require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../src/controllers/UserController.php'; 

$userController = new UserController($pdo);

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php'); 
    exit;
}

if (isset($_POST['logout'])) {
    $userController->logout(); 
}

include '../src/views/user.php';
?>
