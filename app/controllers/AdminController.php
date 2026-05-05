<?php
class AdminController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->checkAdmin();
    }

    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit();
        }
    }

    public function dashboard() {
        // Statistics
        $usersCount = $this->conn->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();
        $ordersCount = $this->conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $revenue = $this->conn->query("SELECT SUM(total_price) FROM orders WHERE status != 'Cancelled'")->fetchColumn();
        $foodCount = $this->conn->query("SELECT COUNT(*) FROM food_items")->fetchColumn();

        require_once '../app/views/admin/dashboard.php';
    }

    public function users() {
        if (isset($_GET['delete_id'])) {
            $id = (int)$_GET['delete_id'];
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id AND role = 'customer'");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            header("Location: index.php?action=admin_users");
            exit();
        }

        $query = "SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC";
        $users = $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/admin/users.php';
    }

    public function menu() {
        $query = "SELECT f.*, c.name as category_name FROM food_items f LEFT JOIN categories c ON f.category_id = c.id";
        $items = $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
        
        $categories = $this->conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/admin/menu.php';
    }

    public function addFood() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $image = '';

            // Handle image upload basic
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $target_dir = "../public/assets/images/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image = time() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            }

            $query = "INSERT INTO food_items (category_id, name, price, description, image) VALUES (:cat, :name, :price, :desc, :img)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cat', $category_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':desc', $description);
            $stmt->bindParam(':img', $image);
            $stmt->execute();

            header("Location: index.php?action=admin_menu");
            exit();
        }
    }

    public function deleteFood() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $stmt = $this->conn->prepare("DELETE FROM food_items WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        }
        header("Location: index.php?action=admin_menu");
        exit();
    }

    public function orders() {
        $query = "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC";
        $orders = $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/admin/orders.php';
    }

    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'];
            $status = $_POST['status'];

            $query = "UPDATE orders SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $order_id);
            $stmt->execute();
        }
        header("Location: index.php?action=admin_orders");
        exit();
    }
}
?>
