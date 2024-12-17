<?php
include '../config/database.php';
include '../src/models/Recipe.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_name'])) {
    $recipeId = $_POST['recipe_id'];
    $userId = $_SESSION['user_id'];
    $rating = (int) ($_POST['rating'] ?? 0); 
    $comment = trim($_POST['comment'] ?? null);

    if ($rating >= 1 && $rating <= 5) {
        $stmt = $pdo->prepare("INSERT INTO reviews (id_user, id_recipe, text, rating, date) 
                               VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$userId, $recipeId, $comment, $rating]);
        header("Location: recipe.php?id=$recipeId");
        exit;
    } else {
        echo "Будь ласка, виставте оцінку від 1 до 5.";
    }
} else {
    echo "Ви повинні увійти, щоб залишити відгук.";
}
?>
