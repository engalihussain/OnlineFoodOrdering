<?php
class OrderController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        // Fetch cart items
        $query = "SELECT ci.quantity, f.price 
                  FROM cart_items ci 
                  JOIN carts c ON ci.cart_id = c.id
                  JOIN food_items f ON ci.item_id = f.id 
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $_SESSION['user_id']);
        $stmt->execute();
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cart_items)) {
            header("Location: index.php?action=cart");
            exit();
        }

        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $total += 5.00; // Delivery fee

        require_once '../app/views/checkout.php';
    }

    public function placeOrder() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $payment_method = $_POST['payment_method'] ?? 'Cash on Delivery';

        // 1. Calculate total from cart
        $cartQuery = "SELECT ci.item_id, ci.quantity, f.price, c.id as cart_id
                      FROM cart_items ci 
                      JOIN carts c ON ci.cart_id = c.id
                      JOIN food_items f ON ci.item_id = f.id 
                      WHERE c.user_id = :user_id";
        $cartStmt = $this->conn->prepare($cartQuery);
        $cartStmt->bindParam(":user_id", $user_id);
        $cartStmt->execute();
        $cart_items = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cart_items)) {
            header("Location: index.php?action=cart");
            exit();
        }

        $total = 0;
        $cart_id = $cart_items[0]['cart_id'];
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $total += 5.00; // Delivery fee

        try {
            $this->conn->beginTransaction();

            // 2. Create Order
            $orderQuery = "INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total, 'Pending')";
            $orderStmt = $this->conn->prepare($orderQuery);
            $orderStmt->bindParam(":user_id", $user_id);
            $orderStmt->bindParam(":total", $total);
            $orderStmt->execute();
            $order_id = $this->conn->lastInsertId();

            // 3. Create Order Items
            $itemQuery = "INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (:order_id, :item_id, :quantity, :price)";
            $itemStmt = $this->conn->prepare($itemQuery);
            foreach ($cart_items as $item) {
                $itemStmt->bindParam(":order_id", $order_id);
                $itemStmt->bindParam(":item_id", $item['item_id']);
                $itemStmt->bindParam(":quantity", $item['quantity']);
                $itemStmt->bindParam(":price", $item['price']);
                $itemStmt->execute();
            }

            // 4. Create Payment Record
            $paymentQuery = "INSERT INTO payments (order_id, amount, method, status) VALUES (:order_id, :amount, :method, 'Pending')";
            $paymentStmt = $this->conn->prepare($paymentQuery);
            $paymentStmt->bindParam(":order_id", $order_id);
            $paymentStmt->bindParam(":amount", $total);
            $paymentStmt->bindParam(":method", $payment_method);
            $paymentStmt->execute();

            // 5. Clear Cart
            $clearCartQuery = "DELETE FROM cart_items WHERE cart_id = :cart_id";
            $clearCartStmt = $this->conn->prepare($clearCartQuery);
            $clearCartStmt->bindParam(":cart_id", $cart_id);
            $clearCartStmt->execute();

            $this->conn->commit();
            
            $_SESSION['cart_count'] = 0;
            header("Location: index.php?action=order_success&id=" . $order_id);
            exit();

        } catch (Exception $e) {
            $this->conn->rollBack();
            die("Order failed: " . $e->getMessage());
        }
    }

    public function success() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        require_once '../app/views/order_success.php';
    }

    public function history() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/order_history.php';
    }
}
?>
