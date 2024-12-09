<!-- // src/models/Recipe.php -->
<?php
class Recipe {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllRecipesByCategory($categoryId) {
        $stmt = $this->pdo->prepare("SELECT * FROM recipes WHERE id_category = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipeById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM recipes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRatings($recipeId) {
        $stmt = $this->pdo->prepare("SELECT AVG(rating) as average, COUNT(rating) as count FROM ratings WHERE id_recipe = ?");
        $stmt->execute([$recipeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getReviews($recipeId) {
        $stmt = $this->pdo->prepare("SELECT r.text, u.name, r.date FROM reviews r JOIN users u ON r.id_user = u.id WHERE r.id_recipe = ? ORDER BY r.date DESC");
        $stmt->execute([$recipeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIngredients($recipeId) {
        $stmt = $this->pdo->prepare("
            SELECT i.name AS name, ri.quantity AS quantity
            FROM recipes_ingredients ri
            JOIN ingredients i ON ri.id_ingredient = i.id
            WHERE ri.id_recipe = ?;
        ");
        $stmt->execute([$recipeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function searchRecipes($keyword) {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT r.*
            FROM recipes r
            LEFT JOIN recipes_ingredients ri ON r.id = ri.id_recipe
            LEFT JOIN ingredients i ON ri.id_ingredient = i.id
            WHERE r.name LIKE ? 
               OR r.description LIKE ? 
               OR r.instructions LIKE ?
               OR i.name LIKE ?
            ORDER BY r.date DESC
        ");
    
        $searchTerm = '%' . $keyword . '%';
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredRecipesByCategory($categoryId, $ingredientIds) {
        $query = "
            SELECT DISTINCT r.*
            FROM recipes r
            JOIN recipes_ingredients ri ON r.id = ri.id_recipe
            WHERE r.id_category = ?
        ";
        $params = [$categoryId];
    
        // Якщо вибрані інгредієнти, додаємо їх до фільтру
        if (!empty($ingredientIds)) {
            $placeholders = implode(',', array_fill(0, count($ingredientIds), '?'));
            $query .= " AND ri.id_ingredient IN ($placeholders) GROUP BY r.id
            HAVING COUNT(DISTINCT ri.id_ingredient) = ?";
            $params = array_merge($params, $ingredientIds, [count($ingredientIds)]);
        } else {
            $query .= " GROUP BY r.id";
        }
    
        $stmt = $this->pdo->prepare($query);
        
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
