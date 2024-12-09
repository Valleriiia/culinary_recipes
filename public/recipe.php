<?php
include '../config/database.php';
include '../src/controllers/RecipeController.php';

// Перевіряємо, чи передано параметр ID рецепта
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $controller = new RecipeController($pdo);
    $controller->showRecipe($_GET['id']);
} else {
    echo "Невірний ID рецепта.";
}
