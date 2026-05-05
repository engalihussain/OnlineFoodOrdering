<?php include '../app/views/layout/header.php'; ?>

<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-10 rounded-2xl shadow-xl text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-4xl text-green-500"></i>
        </div>
        
        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Order Placed!</h2>
        <p class="text-gray-600 mb-8">
            Thank you for your order. Your order ID is <strong>#<?php echo htmlspecialchars($order_id); ?></strong>. We will start preparing your delicious food right away!
        </p>
        
        <div class="space-y-4">
            <a href="index.php?action=order_history" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 smooth-transition">
                Track Order
            </a>
            <a href="index.php?action=home" class="w-full flex justify-center py-3 px-4 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 smooth-transition">
                Return Home
            </a>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
