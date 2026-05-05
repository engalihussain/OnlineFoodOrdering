<?php include '../app/views/layout/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Checkout</h1>
            
            <div class="mb-8 p-6 bg-orange-50 rounded-xl border border-orange-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                <div class="flex justify-between items-center text-lg font-bold text-orange-600">
                    <span>Total Amount to Pay:</span>
                    <span><?php echo number_format($total, 2); ?> SAR</span>
                </div>
            </div>

            <form action="index.php?action=place_order" method="POST">
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Method</h3>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 smooth-transition">
                            <input type="radio" name="payment_method" value="Cash on Delivery" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300" checked>
                            <span class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-gray-900"><i class="fas fa-money-bill-wave text-green-500 mr-2"></i>Cash on Delivery</span>
                                <span class="block text-sm text-gray-500">Pay when you receive the order</span>
                            </span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-not-allowed opacity-60">
                            <input type="radio" name="payment_method" value="Online" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300" disabled>
                            <span class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-gray-900"><i class="fas fa-credit-card text-blue-500 mr-2"></i>Online Payment (Coming Soon)</span>
                                <span class="block text-sm text-gray-500">Pay securely with your credit card</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Delivery Address</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Full Address</label>
                            <textarea id="address" name="address" rows="3" required class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Enter your delivery address..."></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl shadow-sm text-white bg-orange-600 hover:bg-orange-700 smooth-transition">
                    Confirm Order
                </button>
            </form>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
