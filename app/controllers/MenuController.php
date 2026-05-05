<?php
class MenuController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        $category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;

        // Fetch categories
        $catQuery = "SELECT * FROM categories";
        $catStmt = $this->conn->prepare($catQuery);
        $catStmt->execute();
        $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch menu items
        if ($category_id) {
            $query = "SELECT f.*, c.name as category_name FROM food_items f JOIN categories c ON f.category_id = c.id WHERE f.category_id = :cat_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cat_id', $category_id);
        } else {
            $query = "SELECT f.*, c.name as category_name FROM food_items f LEFT JOIN categories c ON f.category_id = c.id";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/menu.php';
    }
}
?>
