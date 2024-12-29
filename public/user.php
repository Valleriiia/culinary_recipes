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

// Перевірка, чи рецепт вже додано в обране
$recipeId = $recipe['id'];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites WHERE id_user = ? AND id_recipe = ?");
$stmt->execute([$userId, $recipeId]);
$isFavorite = $stmt->fetchColumn() > 0;
$icon = $isFavorite ? '6.svg' : '5.svg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        $userController->logout();
        header('Location: login.php');
        exit;
    }

    if (isset($_POST['toggle_favorite'])) {
        $recipeId = $_POST['recipe_id'] ?? null;

        if ($recipeId && $userId) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites WHERE id_user = ? AND id_recipe = ?");
            $stmt->execute([$userId, $recipeId]);
            $isFavorite = $stmt->fetchColumn() > 0;

            if ($isFavorite) {
                $stmt = $pdo->prepare("DELETE FROM favorites WHERE id_user = ? AND id_recipe = ?");
                $stmt->execute([$userId, $recipeId]);
                $message = "Рецепт видалено з обраного.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO favorites (id_user, id_recipe) VALUES (?, ?)");
                $stmt->execute([$userId, $recipeId]);
                $message = "Рецепт додано в обране.";
            }

            echo json_encode(['success' => true, 'message' => $message]);
            exit;
        }
    }

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

    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $message = "Всі поля обов'язкові для заповнення.";
            $messageType = 'error';
        } elseif ($newPassword !== $confirmPassword) {
            $message = "Паролі не співпадають!";
            $messageType = 'error';
        } else {
            $message = $userController->changeUserPassword($userId, $currentPassword, $newPassword);
            $messageType = $message === 'Пароль успішно змінено!' ? 'success' : 'error';
        }
    }

    if (isset($_GET['recipe_id'])) {
        $recipeId = $_GET['recipe_id'];
        $ratingData = $userController->getRecipeRating($recipeId);

        if ($ratingData) {
            $averageRating = $ratingData['average'] ?? 0;
            $reviewCount = $ratingData['count'] ?? 0;

            echo json_encode([
                'success' => true,
                'average_rating' => $averageRating,
                'review_count' => $reviewCount
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Не вдалося отримати рейтинг рецепта.']);
        }
        exit;
    }
}

$profilePhotoUrl = $userController->getUserProfile($userId);
include '../src/views/user.php';
?>
