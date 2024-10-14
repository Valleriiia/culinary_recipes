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

    public function searchRecipes($keyword) {
        $stmt = $this->pdo->prepare("SELECT * FROM recipes WHERE title LIKE ? OR ingredients LIKE ?");
        $search = "%".$keyword."%";
        $stmt->execute([$search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
