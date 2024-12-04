<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

$userController = new UserController($pdo);

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['update_profile'])) {
    $userId = $_SESSION['user_id'];
    $newUsername = $_POST['new_username'];
    $profilePhotoPath = null;

    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/profile_photos/';
        $fileName = basename($_FILES['profile_photo']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedExtensions)) {
            $newFileName = uniqid('profile_', true) . '.' . $fileExt; 
            $uploadFile = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
                $profilePhotoPath = '/images/profile_photos/' . $newFileName;
            }
        }
    }

    $message = $userController->updateUserProfile($userId, $newUsername, $profilePhotoPath);

    $_SESSION['user_name'] = $newUsername;

    header('Location: user.php');
    exit;
}
if (isset($_POST['change_password'])) {
    $userId = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $message = "Паролі не співпадають!";
    } else {
        $message = $userController->changeUserPassword($userId, $currentPassword, $newPassword);
    }

    echo $message;
}

if (isset($_POST['logout'])) {
    $userController->logout();  
}

if (!isset($_SESSION['user_name'])) {
    header('Location: index.php');
    exit;
}

$profilePhotoUrl = $userController->getUserProfile($_SESSION['user_id']);
include '../src/views/user.php';
?>
