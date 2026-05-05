<?php
class HomeController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        // Fetch some featured categories and items
        $query = "SELECT * FROM food_items LIMIT 6";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $featured_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/home.php';
    }
}
?>
