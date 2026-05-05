<?php include '../app/views/layout/header.php'; ?>

<div class="flex h-[calc(100vh-64px)] bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md flex-shrink-0">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
        </div>
        <nav class="mt-2 space-y-1">
            <a href="index.php?action=admin_dashboard" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Dashboard
            </a>
            <a href="index.php?action=admin_users" class="bg-orange-50 border-r-4 border-orange-500 text-orange-600 group flex items-center px-6 py-3 text-sm font-medium">
                <i class="fas fa-users mr-3 text-orange-500"></i>
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
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Manage Users</h1>
            
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $user['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="index.php?action=admin_users&delete_id=<?php echo $user['id']; ?>" class="text-red-600 hover:text-red-900 smooth-transition" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(empty($users)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No customers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
