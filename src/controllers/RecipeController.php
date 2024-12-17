<!-- // src/controllers/RecipeController.php -->


<?php

include '../src/models/Recipe.php';

class RecipeController {
    private $recipeModel;

    public function __construct($pdo) {
        $this->recipeModel = new Recipe($pdo);
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
        include __DIR__ . '/../views/recipe.php';
    }

    public function searchRecipes($keyword) {
        $results = $this->recipeModel->searchRecipes($keyword);
        include __DIR__ . '/../views/search.php';
    }
}
?>
