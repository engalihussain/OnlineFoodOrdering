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
                        <?php
                            $itemStmt = $this->conn->prepare("SELECT oi.quantity, oi.price, f.name FROM order_items oi JOIN food_items f ON oi.item_id = f.id WHERE oi.order_id = :order_id");
                            $itemStmt->bindParam(':order_id', $order['id']);
                            $itemStmt->execute();
                            $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            $orderData = [
                                'id' => $order['id'],
                                'status' => $order['status'],
                                'date' => date('M d, Y H:i A', strtotime($order['created_at'])),
                                'address' => $order['delivery_address'] ?? 'No Address Provided',
                                'total' => number_format($order['total_price'], 2),
                                'items' => $items
                            ];
                            $orderJson = htmlspecialchars(json_encode($orderData), ENT_QUOTES, 'UTF-8');
                        ?>
                        <li>
                            <div class="px-4 py-6 sm:px-6 hover:bg-gray-50 smooth-transition">
                                <div class="flex items-center justify-between">
                                    <a href="#" class="text-lg font-medium text-orange-600 truncate hover:underline" onclick="event.preventDefault(); openOrderModal(this)" data-order='<?php echo $orderJson; ?>'>
                                        Order #<?php echo $order['id']; ?>
                                    </a>
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

<!-- Order Details Modal -->
<div id="orderModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeOrderModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                        Order Details
                    </h3>
                    <button type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeOrderModal()">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mt-4">
                    <div class="flex justify-between text-sm mb-4">
                        <span class="font-semibold text-gray-700">Order ID: <span id="modal-order-id" class="text-orange-600"></span></span>
                        <span id="modal-order-status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"></span>
                    </div>
                    <p class="text-xs text-gray-500 mb-2" id="modal-order-date"></p>
                    <p class="text-sm text-gray-700 mb-4 font-medium"><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i> <span id="modal-order-address"></span></p>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-bold text-gray-900 mb-2">Items</h4>
                        <ul id="modal-items-list" class="divide-y divide-gray-200 text-sm">
                            <!-- Items injected here via JS -->
                        </ul>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4 flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total Price</span>
                        <span class="font-black text-orange-600 text-lg" id="modal-total-price"></span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm smooth-transition" onclick="closeOrderModal()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openOrderModal(element) {
    const orderData = JSON.parse(element.getAttribute('data-order'));
    
    document.getElementById('modal-order-id').innerText = '#' + orderData.id;
    document.getElementById('modal-order-date').innerText = 'Placed on ' + orderData.date;
    document.getElementById('modal-order-address').innerText = orderData.address;
    document.getElementById('modal-total-price').innerText = orderData.total + ' SAR';
    
    const statusBadge = document.getElementById('modal-order-status');
    statusBadge.innerText = orderData.status;
    statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full ';
    if(orderData.status === 'Pending') statusBadge.className += 'bg-yellow-100 text-yellow-800';
    else if(orderData.status === 'Preparing') statusBadge.className += 'bg-blue-100 text-blue-800';
    else if(orderData.status === 'Delivered') statusBadge.className += 'bg-green-100 text-green-800';
    else if(orderData.status === 'Cancelled') statusBadge.className += 'bg-red-100 text-red-800';
    else statusBadge.className += 'bg-gray-100 text-gray-800';
    
    const itemsList = document.getElementById('modal-items-list');
    itemsList.innerHTML = '';
    
    let hasDelivery = false;
    orderData.items.forEach(item => {
        const li = document.createElement('li');
        li.className = 'py-2 flex justify-between';
        
        const subtotal = (parseFloat(item.price) * parseInt(item.quantity)).toFixed(2);
        
        li.innerHTML = `
            <div class="flex items-center">
                <span class="font-medium text-gray-900">${item.quantity}x</span>
                <span class="ml-2 text-gray-600">${item.name}</span>
            </div>
            <div class="text-gray-900 font-medium">${subtotal} SAR</div>
        `;
        itemsList.appendChild(li);
    });
    
    // Delivery fee representation (Optional depending on business logic, but it makes the total sum up correctly)
    const deliveryLi = document.createElement('li');
    deliveryLi.className = 'py-2 flex justify-between text-gray-500';
    deliveryLi.innerHTML = `
        <div class="flex items-center">
            <span class="font-medium">1x</span>
            <span class="ml-2">Delivery Fee</span>
        </div>
        <div class="font-medium">5.00 SAR</div>
    `;
    itemsList.appendChild(deliveryLi);

    // Fade in
    const modal = document.getElementById('orderModal');
    modal.classList.remove('hidden');
    modal.style.opacity = 0;
    setTimeout(() => modal.style.opacity = 1, 10);
}

function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    modal.style.opacity = 0;
    setTimeout(() => modal.classList.add('hidden'), 300); // 300ms transition time
}
</script>

<?php include '../app/views/layout/footer.php'; ?>
