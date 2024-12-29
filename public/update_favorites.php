<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    exit;  
}

$userId = $_SESSION['user_id'];
$recipeId = $_POST['recipe_id'];


$stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites WHERE id_user = ? AND id_recipe = ?");
$stmt->execute([$userId, $recipeId]);
$isFavorite = $stmt->fetchColumn() > 0;

if ($isFavorite) {

    $stmt = $pdo->prepare("DELETE FROM favorites WHERE id_user = ? AND id_recipe = ?");
    $stmt->execute([$userId, $recipeId]);
    echo json_encode(['message' => 'Рецепт видалено з улюблених']);
} else {

    $stmt = $pdo->prepare("INSERT INTO favorites (id_user, id_recipe) VALUES (?, ?)");
    $stmt->execute([$userId, $recipeId]);
    echo json_encode(['message' => 'Рецепт додано до улюблених']);
}

?>
