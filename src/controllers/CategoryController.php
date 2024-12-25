<?php

include '../src/models/Category.php';
include '../src/models/Recipe.php';

class CategoryController {
    private $categoryModel;
    private $recipeModel;

    public function __construct($pdo) {
        $this->categoryModel = new Category($pdo);
        $this->recipeModel = new Recipe($pdo);
    }

    // Отримує список усіх категорій для відображення на головній сторінці
    public function showAllCategories() {
        $categories = $this->categoryModel->getAllCategories();
        include __DIR__ . '/../views/index.php';
    }

    public function showCategory($categoryId) {
        $category = $this->categoryModel->getCategoryById($categoryId);
        // $recipes = $this->categoryModel->getRecipesByCategory($categoryId);
        $ingredients = $this->categoryModel->getIngredientsByCategory($categoryId);

        $selectedIngredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : [];
        $recipes = $this->recipeModel->getFilteredRecipesByCategory($categoryId, $selectedIngredients);
        $ratings = [];
        foreach ($recipes as $recipe) {
            $ratings[$recipe['id']] = $this->recipeModel->getRatings($recipe['id']);
            }
        $isLoggedIn = isset($_SESSION['user_name']); 
        include __DIR__ . '/../views/category.php';
    }
}
