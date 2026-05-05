<?php include '../app/views/layout/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">My Orders</h1>

        <?php if(empty($orders)): ?>
            <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-receipt text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No orders yet</h2>
                <p class="text-gray-500 mb-8">You haven't placed any orders with us yet.</p>
                <a href="index.php?action=menu" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-orange-600 hover:bg-orange-700 smooth-transition">
                    Explore Menu
                </a>
            </div>
        <?php else: ?>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    <?php foreach($orders as $order): ?>
                        <li>
                            <div class="px-4 py-6 sm:px-6 hover:bg-gray-50 smooth-transition">
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-medium text-orange-600 truncate">
                                        Order #<?php echo $order['id']; ?>
                                    </p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <?php 
                                            $statusColor = 'bg-gray-100 text-gray-800';
                                            if($order['status'] == 'Pending') $statusColor = 'bg-yellow-100 text-yellow-800';
                                            if($order['status'] == 'Preparing') $statusColor = 'bg-blue-100 text-blue-800';
                                            if($order['status'] == 'Delivered') $statusColor = 'bg-green-100 text-green-800';
                                            if($order['status'] == 'Cancelled') $statusColor = 'bg-red-100 text-red-800';
                                        ?>
                                        <p class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusColor; ?>">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500 font-bold">
                                            <?php echo number_format($order['total_price'], 2); ?> SAR
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <i class="fas fa-calendar-alt flex-shrink-0 mr-1.5 text-gray-400"></i>
                                        <p>
                                            Placed on <time datetime="<?php echo $order['created_at']; ?>"><?php echo date('M d, Y H:i A', strtotime($order['created_at'])); ?></time>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
