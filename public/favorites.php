<?php
session_start();
require_once '../config/database.php';
require_once '../src/controllers/UserController.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

$userId = $_SESSION['user_id'];
$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeId = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : null;

    if (!$recipeId) {
        exit; 
    }

    if (isset($_POST['add_favorite'])) {
        // Додаємо рецепт до улюблених
        $userController->addToFavorites($userId, $recipeId);
    } elseif (isset($_POST['remove_favorite'])) {
        // Видаляємо рецепт з улюблених
        $userController->removeFromFavorites($userId, $recipeId);
    }
}

if (isset($_POST['recipe_id']) && isset($_POST['remove_favorite'])) {
    $recipeId = $_POST['recipe_id'];

    $success = $userController->removeFromFavorites($userId, $recipeId);

    if ($success) {
        echo json_encode(['success' => true]); 
    } else {
        echo json_encode(['success' => false, 'message' => 'Не вдалося видалити рецепт.']); 
    }
    exit;
}


$favorites = $userController->getFavoriteRecipes($userId);


include '../src/views/favorites.php';
?>
