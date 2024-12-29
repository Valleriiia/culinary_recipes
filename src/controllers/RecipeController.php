<!-- // src/controllers/RecipeController.php -->


<?php

include '../src/models/Recipe.php';
include '../src/models/User.php';

class RecipeController {
    private $recipeModel;
    private $userModel;

    public function __construct($pdo) {
        $this->recipeModel = new Recipe($pdo);
        $this->userModel = new User($pdo);
    }

    public function showCategory($categoryId) {
        $recipes = $this->recipeModel->getAllRecipesByCategory($categoryId);
        include __DIR__ . '/../views/category.php';
    }

    public function showRecipe($recipeId) {
        $recipe = $this->recipeModel->getRecipeById($recipeId);
        $ratings = $this->recipeModel->getRatings($recipeId);
        $reviews = $this->recipeModel->getReviews($recipeId);
        $ingredients = $this->recipeModel->getIngredients($recipeId);
        $isLoggedIn = isset($_SESSION['user_name']); 
        if ($isLoggedIn) {
            $user_photo = $this->userModel->getUserProfile($_SESSION['user_id']);
        }
        include __DIR__ . '/../views/recipe.php';
    }

    public function searchRecipes($keyword) {
        $results = $this->recipeModel->searchRecipes($keyword);
        $ratings = [];
        foreach ($results as $result) {
            $ratings[$result['id']] = $this->recipeModel->getRatings($result['id']);
        }
        $isLoggedIn = isset($_SESSION['user_name']); 
        include __DIR__ . '/../views/search.php';
    }
}
?>
