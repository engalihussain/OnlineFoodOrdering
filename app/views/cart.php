<?php include '../app/views/layout/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Shopping Cart</h1>

        <?php if(empty($cart_items)): ?>
            <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
                <a href="index.php?action=menu" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-orange-600 hover:bg-orange-700 smooth-transition">
                    Browse Menu
                </a>
            </div>
        <?php else: ?>
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-grow">
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            <?php foreach($cart_items as $item): ?>
                                <li class="p-6 flex flex-col sm:flex-row items-center gap-6">
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                        <?php $imgSrc = !empty($item['image']) ? "assets/images/" . $item['image'] : "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"; ?>
                                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-full w-full object-cover object-center">
                                    </div>

                                    <div class="flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                                <p class="ml-4"><?php echo number_format($item['price'], 2); ?> SAR</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm mt-4">
                                            <form action="index.php?action=update_cart" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.submit();" class="px-3 py-1 bg-gray-50 text-gray-600 hover:bg-gray-100 smooth-transition">-</button>
                                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="w-12 text-center py-1 border-none focus:ring-0 text-sm" onchange="this.form.submit()">
                                                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.submit();" class="px-3 py-1 bg-gray-50 text-gray-600 hover:bg-gray-100 smooth-transition">+</button>
                                            </form>

                                            <div class="flex">
                                                <a href="index.php?action=remove_from_cart&id=<?php echo $item['id']; ?>" class="font-medium text-red-500 hover:text-red-400 flex items-center smooth-transition">
                                                    <i class="fas fa-trash-alt mr-1"></i> Remove
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="w-full lg:w-96 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Order Summary</h2>
                        
                        <div class="flow-root">
                            <dl class="-my-4 text-sm divide-y divide-gray-200">
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-gray-600">Subtotal</dt>
                                    <dd class="font-medium text-gray-900"><?php echo number_format($total, 2); ?> SAR</dd>
                                </div>
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-gray-600">Delivery Fee</dt>
                                    <dd class="font-medium text-gray-900">5.00 SAR</dd>
                                </div>
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-base font-bold text-gray-900">Order Total</dt>
                                    <dd class="text-base font-bold text-orange-600"><?php echo number_format($total + 5.00, 2); ?> SAR</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <a href="index.php?action=checkout" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-orange-600 hover:bg-orange-700 smooth-transition">
                                Proceed to Checkout
                            </a>
                        </div>
                        <div class="mt-4 flex justify-center text-center text-sm text-gray-500">
                            <p>
                                or
                                <a href="index.php?action=menu" class="font-medium text-orange-600 hover:text-orange-500">
                                    Continue Shopping <span aria-hidden="true">&rarr;</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
