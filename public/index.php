<?php
session_start();

require_once '../app/config/database.php';

// Simple routing based on action
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// Connect to DB
$db = new Database();
$conn = $db->getConnection();

// Route logic
switch ($action) {
    case 'home':
        require_once '../app/controllers/HomeController.php';
        $controller = new HomeController($conn);
        $controller->index();
        break;
        
    case 'menu':
        require_once '../app/controllers/MenuController.php';
        $controller = new MenuController($conn);
        $controller->index();
        break;

    case 'login':
    case 'register':
    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $controller = new AuthController($conn);
        if ($action == 'login') {
            $controller->login();
        } elseif ($action == 'register') {
            $controller->register();
        } else {
            $controller->logout();
        }
        break;

    case 'cart':
    case 'add_to_cart':
    case 'update_cart':
    case 'remove_from_cart':
        require_once '../app/controllers/CartController.php';
        $controller = new CartController($conn);
        if ($action == 'cart') $controller->index();
        elseif ($action == 'add_to_cart') $controller->add();
        elseif ($action == 'update_cart') $controller->update();
        elseif ($action == 'remove_from_cart') $controller->remove();
        break;
        
    case 'checkout':
    case 'place_order':
    case 'order_success':
    case 'order_history':
        require_once '../app/controllers/OrderController.php';
        $controller = new OrderController($conn);
        if ($action == 'checkout') $controller->checkout();
        elseif ($action == 'place_order') $controller->placeOrder();
        elseif ($action == 'order_success') $controller->success();
        elseif ($action == 'order_history') $controller->history();
        break;

    case 'admin_dashboard':
    case 'admin_users':
    case 'admin_menu':
    case 'admin_orders':
    case 'admin_add_food':
    case 'admin_delete_food':
    case 'admin_update_order_status':
        require_once '../app/controllers/AdminController.php';
        $controller = new AdminController($conn);
        if ($action == 'admin_dashboard') $controller->dashboard();
        elseif ($action == 'admin_users') $controller->users();
        elseif ($action == 'admin_menu') $controller->menu();
        elseif ($action == 'admin_orders') $controller->orders();
        elseif ($action == 'admin_add_food') $controller->addFood();
        elseif ($action == 'admin_delete_food') $controller->deleteFood();
        elseif ($action == 'admin_update_order_status') $controller->updateOrderStatus();
        break;

    default:
        echo "404 Not Found";
        break;
}
?>
