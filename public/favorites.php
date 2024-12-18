<?php
session_start();
require_once '../config/database.php';
require_once '../src/controllers/UserController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeId = (int)$_POST['recipe_id'];

    if (isset($_POST['add_favorite'])) {
        $userController->addToFavorites($userId, $recipeId);
    }

    if (isset($_POST['remove_favorite'])) {
        $userController->removeFromFavorites($userId, $recipeId);
    }
}

$favorites = $userController->getFavoriteRecipes($userId);

include '../src/views/favorites.php';
