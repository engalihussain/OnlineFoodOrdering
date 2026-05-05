<?php
class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $error = "Please fill in all fields.";
            } else {
                $query = "SELECT id, name, password, role FROM users WHERE email = :email";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":email", $email);
                $stmt->execute();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['user_name'] = $row['name'];
                        $_SESSION['user_role'] = $row['role'];
                        
                        // Get cart count
                        $cartQuery = "SELECT id FROM carts WHERE user_id = :user_id";
                        $cartStmt = $this->conn->prepare($cartQuery);
                        $cartStmt->bindParam(":user_id", $row['id']);
                        $cartStmt->execute();
                        if($cartRow = $cartStmt->fetch(PDO::FETCH_ASSOC)) {
                            $countQuery = "SELECT SUM(quantity) as count FROM cart_items WHERE cart_id = :cart_id";
                            $countStmt = $this->conn->prepare($countQuery);
                            $countStmt->bindParam(":cart_id", $cartRow['id']);
                            $countStmt->execute();
                            $countRow = $countStmt->fetch(PDO::FETCH_ASSOC);
                            $_SESSION['cart_count'] = $countRow['count'] ?? 0;
                        } else {
                            $_SESSION['cart_count'] = 0;
                        }

                        if ($row['role'] === 'admin') {
                            header("Location: index.php?action=admin_dashboard");
                        } else {
                            header("Location: index.php?action=home");
                        }
                        exit();
                    } else {
                        $error = "Invalid password.";
                    }
                } else {
                    $error = "No user found with that email.";
                }
            }
        }
        require_once '../app/views/auth/login.php';
    }

    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (empty($name) || empty($email) || empty($password)) {
                $error = "Please fill in all fields.";
            } else {
                // Check if email exists
                $checkQuery = "SELECT id FROM users WHERE email = :email";
                $checkStmt = $this->conn->prepare($checkQuery);
                $checkStmt->bindParam(":email", $email);
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0) {
                    $error = "Email already exists.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $hashed_password);

                    if ($stmt->execute()) {
                        header("Location: index.php?action=login");
                        exit();
                    } else {
                        $error = "Registration failed. Please try again.";
                    }
                }
            }
        }
        require_once '../app/views/auth/register.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?action=home");
        exit();
    }
}
?>
