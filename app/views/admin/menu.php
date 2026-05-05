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
            <a href="index.php?action=admin_menu" class="bg-orange-50 border-r-4 border-orange-500 text-orange-600 group flex items-center px-6 py-3 text-sm font-medium">
                <i class="fas fa-hamburger mr-3 text-orange-500"></i>
                Menu Items
            </a>
            <a href="index.php?action=admin_orders" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-6 py-3 text-sm font-medium smooth-transition">
                <i class="fas fa-shopping-bag mr-3 text-gray-400 group-hover:text-gray-500"></i>
                Orders
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Manage Menu</h1>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Add New Food Item</h2>
            <form action="index.php?action=admin_add_food" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-2 border">
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price (SAR)</label>
                        <input type="number" step="0.01" name="price" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 p-1 border border-gray-300 rounded-md">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-2 border"></textarea>
                </div>
                <div>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 smooth-transition">
                        Add Item
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($items as $item): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php $imgSrc = !empty($item['image']) ? "assets/images/" . $item['image'] : "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=60"; ?>
                                        <img class="h-10 w-10 rounded-full object-cover" src="<?php echo $imgSrc; ?>" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['category_name'] ?? 'N/A'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold"><?php echo number_format($item['price'], 2); ?> SAR</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="index.php?action=admin_delete_food&id=<?php echo $item['id']; ?>" class="text-red-600 hover:text-red-900 smooth-transition" onclick="return confirm('Delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
