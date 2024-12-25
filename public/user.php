<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

$userController = new UserController($pdo);

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$message = ''; 
$messageType = null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Оновлення профілю
    if (isset($_POST['update_profile'])) {
        $newUsername = trim($_POST['new_username']);
        $currentProfilePhoto = $userController->getUserProfile($userId);
        $profilePhotoPath = $currentProfilePhoto;

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

                    if ($currentProfilePhoto && file_exists(__DIR__ . '/../' . $currentProfilePhoto)) {
                        unlink(__DIR__ . '/../' . $currentProfilePhoto);
                    }
                } else {
                    $message = "Помилка завантаження фото профілю.";
                }
            } else {
                $message = "Непідтримуваний формат файлу. Доступні формати: JPG, JPEG, PNG, GIF.";
            }
        }

        if (empty($message)) {
            $message = $userController->updateUserProfile($userId, $newUsername, $profilePhotoPath);
            $_SESSION['user_name'] = $newUsername; 
            $messageType = 'success'; 
            header('Location: user.php');
            exit;
        }
    }

    // Зміна паролю
    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $message = "Усі поля обов'язкові для заповнення.";
            $messageType = 'error';
        } elseif ($newPassword !== $confirmPassword) {
            $message = "Паролі не співпадають!";
            $messageType = 'error';
        } else {
            $message = $userController->changeUserPassword($userId, $currentPassword, $newPassword);
            $messageType = $message === 'Пароль успішно змінено!' ? 'success' : 'error';
            $passwordChangedSuccessfully = true; // або false, залежно від логіки зміни пароля

        }
    }

    // Логаут
    if (isset($_POST['logout'])) {
        $userController->logout();
        header('Location: login.php');
        exit;
    }

    // Робота з обраними рецептами
    if (isset($_POST['toggle_favorite'])) {
        $recipeId = $_POST['recipe_id'] ?? null;
        $isFavorite = false;

        if ($recipeId && $userId) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites WHERE id_user = ? AND id_recipe = ?");
            $stmt->execute([$userId, $recipeId]);
            $isFavorite = $stmt->fetchColumn() > 0;
        }

        if ($isFavorite) {
            $stmt = $pdo->prepare("DELETE FROM favorites WHERE id_user = ? AND id_recipe = ?");
            $stmt->execute([$userId, $recipeId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO favorites (id_user, id_recipe) VALUES (?, ?)");
            $stmt->execute([$userId, $recipeId]);
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

$profilePhotoUrl = $userController->getUserProfile($userId);
include '../src/views/user.php';
?>
