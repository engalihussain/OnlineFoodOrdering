<?php include '../app/views/layout/header.php'; ?>

<div class="flex h-[calc(100vh-64px)] bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md flex-shrink-0">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
        </div>
        <nav class="mt-2 space-y-1">
            <a href="index.php?action=admin_dashboard" class="bg-orange-50 border-r-4 border-orange-500 text-orange-600 group flex items-center px-6 py-3 text-sm font-medium">
                <i class="fas fa-tachometer-alt mr-3 text-orange-500"></i>
                Dashboard
            </a>
            <a href="index.php?action=admin_users" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Users
            </a>
            <a href="index.php?action=admin_menu" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-hamburger mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Menu Items
            </a>
            <a href="index.php?action=admin_orders" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-shopping-bag mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Orders
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="p-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Dashboard Overview</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium">Total Users</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($usersCount); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-dollar-sign text-2xl"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium">Total Revenue</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($revenue ?? 0, 2); ?> SAR</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <i class="fas fa-shopping-bag text-2xl"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium">Total Orders</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($ordersCount); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-hamburger text-2xl"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500 text-sm font-medium">Menu Items</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($foodCount); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Welcome back, Admin!</h2>
                <p class="text-gray-600">Use the sidebar to navigate through the system and manage users, menu items, and orders effectively.</p>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
