<?php
class CartController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    private function getCartId($user_id) {
        $query = "SELECT id FROM carts WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['id'];
        } else {
            $insertQuery = "INSERT INTO carts (user_id) VALUES (:user_id)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(":user_id", $user_id);
            $insertStmt->execute();
            return $this->conn->lastInsertId();
        }
    }

    private function updateCartCount($cart_id) {
        $countQuery = "SELECT SUM(quantity) as count FROM cart_items WHERE cart_id = :cart_id";
        $countStmt = $this->conn->prepare($countQuery);
        $countStmt->bindParam(":cart_id", $cart_id);
        $countStmt->execute();
        $countRow = $countStmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['cart_count'] = $countRow['count'] ?? 0;
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $cart_id = $this->getCartId($_SESSION['user_id']);

        $query = "SELECT ci.id, ci.quantity, f.name, f.price, f.image, f.id as item_id 
                  FROM cart_items ci 
                  JOIN food_items f ON ci.item_id = f.id 
                  WHERE ci.cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->execute();
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        require_once '../app/views/cart.php';
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $item_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($item_id) {
            $cart_id = $this->getCartId($_SESSION['user_id']);
            
            // Check if item already in cart
            $checkQuery = "SELECT id, quantity FROM cart_items WHERE cart_id = :cart_id AND item_id = :item_id";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(":cart_id", $cart_id);
            $checkStmt->bindParam(":item_id", $item_id);
            $checkStmt->execute();

            if ($row = $checkStmt->fetch(PDO::FETCH_ASSOC)) {
                $new_quantity = $row['quantity'] + 1;
                $updateQuery = "UPDATE cart_items SET quantity = :qty WHERE id = :id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(":qty", $new_quantity);
                $updateStmt->bindParam(":id", $row['id']);
                $updateStmt->execute();
            } else {
                $insertQuery = "INSERT INTO cart_items (cart_id, item_id, quantity) VALUES (:cart_id, :item_id, 1)";
                $insertStmt = $this->conn->prepare($insertQuery);
                $insertStmt->bindParam(":cart_id", $cart_id);
                $insertStmt->bindParam(":item_id", $item_id);
                $insertStmt->execute();
            }
            
            $this->updateCartCount($cart_id);
        }

        header("Location: index.php?action=cart");
        exit();
    }

    public function update() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=cart");
            exit();
        }

        $cart_item_id = isset($_POST['cart_item_id']) ? (int)$_POST['cart_item_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($cart_item_id && $quantity > 0) {
            $cart_id = $this->getCartId($_SESSION['user_id']);
            
            $query = "UPDATE cart_items SET quantity = :quantity WHERE id = :id AND cart_id = :cart_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":quantity", $quantity);
            $stmt->bindParam(":id", $cart_item_id);
            $stmt->bindParam(":cart_id", $cart_id);
            $stmt->execute();
            
            $this->updateCartCount($cart_id);
        }

        header("Location: index.php?action=cart");
        exit();
    }

    public function remove() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $cart_item_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($cart_item_id) {
            $cart_id = $this->getCartId($_SESSION['user_id']);
            
            $query = "DELETE FROM cart_items WHERE id = :id AND cart_id = :cart_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $cart_item_id);
            $stmt->bindParam(":cart_id", $cart_id);
            $stmt->execute();
            
            $this->updateCartCount($cart_id);
        }

        header("Location: index.php?action=cart");
        exit();
    }
}
?>
