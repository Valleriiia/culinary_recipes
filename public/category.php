<?php
include '../config/database.php';
include '../src/controllers/RecipeController.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $controller = new RecipeController($pdo);
    $controller->showCategory($_GET['id']);
} else {
    echo "Невірний ID категорії.";
}
?>