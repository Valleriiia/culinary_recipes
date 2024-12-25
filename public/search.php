<?php
include '../config/database.php';
include '../src/controllers/RecipeController.php';

session_start();

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

$recipeController = new RecipeController($pdo);
$recipeController->searchRecipes($keyword);
