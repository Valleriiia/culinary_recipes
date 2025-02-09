<?php

class Category {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Отримання інформації про категорію за її ID
    public function getCategoryById($categoryId) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Отримання всіх категорій
    public function getAllCategories() {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipesByCategory($categoryId) {
        $stmt = $this->pdo->prepare("
            SELECT r.* 
            FROM recipes r
            WHERE r.id_category = ?
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Отримати інгредієнти, які використовуються в рецептах цієї категорії
    public function getIngredientsByCategory($categoryId) {
        $stmt = $this->pdo->prepare("
        SELECT i.id, i.name, i.category, COUNT(ri.id_recipe) AS ingredient_frequency, 
        SUM(COUNT(ri.id_recipe)) OVER (PARTITION BY i.category) AS category_frequency
        FROM ingredients i
        JOIN recipes_ingredients ri ON i.id = ri.id_ingredient
        JOIN recipes r ON ri.id_recipe = r.id
        WHERE r.id_category = ? AND i.name NOT IN ('Сіль', 'Спеції', 'Перець горошком')
        GROUP BY i.id, i.name, i.category
        ORDER BY category_frequency DESC, ingredient_frequency DESC, i.name;
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Перевірка, чи існує категорія за назвою
    public function categoryExists($name) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }
}
