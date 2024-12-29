<?php
include '../config/database.php';
include '../src/models/Recipe.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeId = $_POST['recipe_id'];
    $userId = $_SESSION['user_id'];
    $rating = (int) ($_POST['rating'] ?? 0); 
    $comment = trim($_POST['comment'] ?? null);

    if ($rating >= 1 && $rating <= 5) {
        try {
            // Додати новий відгук у базу даних
            $stmt = $pdo->prepare("INSERT INTO reviews (id_user, id_recipe, text, rating, date) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$userId, $recipeId, $comment, $rating]);

            // Отримати дані нового відгуку
            $reviewId = $pdo->lastInsertId();
            $reviewStmt = $pdo->prepare("SELECT r.text, r.rating, DATE_FORMAT(r.date, '%d.%m.%Y') as only_date, 
                                        u.name, u.profile_photo 
                                        FROM reviews r 
                                        JOIN users u ON r.id_user = u.id 
                                        WHERE r.id = ?");
            $reviewStmt->execute([$reviewId]);
            $newReview = $reviewStmt->fetch(PDO::FETCH_ASSOC);

            if ($newReview) {
                echo json_encode(['success' => true, 'review' => $newReview]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Не вдалося завантажити новий відгук.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Помилка запису в базу даних.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Будь ласка, виставте оцінку від 1 до 5.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Ви повинні увійти, щоб залишити відгук.']);
}
?>