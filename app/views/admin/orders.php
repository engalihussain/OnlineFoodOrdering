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
            <a href="index.php?action=admin_users" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Users
            </a>
            <a href="index.php?action=admin_menu" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-hamburger mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Menu Items
            </a>
            <a href="index.php?action=admin_orders" class="bg-orange-50 border-r-4 border-orange-500 text-orange-600 group flex items-center px-6 py-3 text-sm font-medium">
                <i class="fas fa-shopping-bag mr-3 text-orange-500"></i>
                Orders
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto p-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Manage Orders</h1>
        
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#<?php echo $order['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900"><?php echo number_format($order['total_price'], 2); ?> SAR</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs" title="<?php echo htmlspecialchars($order['delivery_address'] ?? 'N/A'); ?>"><?php echo htmlspecialchars($order['delivery_address'] ?? 'N/A'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $statusColor = 'bg-gray-100 text-gray-800';
                                    if($order['status'] == 'Pending') $statusColor = 'bg-yellow-100 text-yellow-800';
                                    if($order['status'] == 'Preparing') $statusColor = 'bg-blue-100 text-blue-800';
                                    if($order['status'] == 'Delivered') $statusColor = 'bg-green-100 text-green-800';
                                    if($order['status'] == 'Cancelled') $statusColor = 'bg-red-100 text-red-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusColor; ?>">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="index.php?action=admin_update_order_status" method="POST" class="flex items-center justify-end">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" onchange="this.form.submit()" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-1 border">
                                        <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Preparing" <?php echo $order['status'] == 'Preparing' ? 'selected' : ''; ?>>Preparing</option>
                                        <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($orders)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
