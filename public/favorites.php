<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

$userController = new UserController($pdo);
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = ''; 


    if (isset($_POST['recipe_id']) && is_numeric($_POST['recipe_id'])) {
        $recipeId = (int)$_POST['recipe_id'];


        if (isset($_POST['add_to_favorites'])) {
            $message = $userController->addRecipeToFavorites($userId, $recipeId);
        }

        if (isset($_POST['remove_from_favorites'])) {
            $message = $userController->removeRecipeFromFavorites($userId, $recipeId);
        }

        if ($message) {
            echo "<p class='message'>" . htmlspecialchars($message) . "</p>";
        }
    } else {
        echo "<p class='error'>Невірний ідентифікатор рецепта.</p>";
    }


    header("Location: favorites.php");
    exit;
}

$favorites = $userController->getFavoriteRecipes($userId);

include '../src/views/favorites.php';
?>
