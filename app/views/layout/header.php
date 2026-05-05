<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bisha Restaurant | Food Ordering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .smooth-transition { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php?action=home" class="flex-shrink-0 flex items-center">
                        <i class="fas fa-utensils text-orange-500 text-2xl mr-2"></i>
                        <span class="font-bold text-xl text-gray-900">Bisha Restaurant</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php?action=home" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium smooth-transition">Home</a>
                    <a href="index.php?action=menu" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium smooth-transition">Menu</a>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['user_role'] === 'admin'): ?>
                            <a href="index.php?action=admin_dashboard" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium smooth-transition">Dashboard</a>
                        <?php else: ?>
                            <a href="index.php?action=order_history" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium smooth-transition">My Orders</a>
                        <?php endif; ?>
                        
                        <?php if($_SESSION['user_role'] !== 'admin'): ?>
                            <a href="index.php?action=cart" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium relative smooth-transition">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <?php if(isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
                                    <span class="absolute top-0 right-0 -mt-1 -mr-1 px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full"><?php echo $_SESSION['cart_count']; ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                        
                        <a href="index.php?action=logout" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-full text-sm font-medium smooth-transition">Logout</a>
                    <?php else: ?>
                        <a href="index.php?action=login" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium smooth-transition">Login</a>
                        <a href="index.php?action=register" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm smooth-transition">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow">
