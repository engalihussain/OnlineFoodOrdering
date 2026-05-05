<?php include '../app/views/layout/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">Our Menu</h1>
            <p class="mt-4 text-xl text-gray-500">Discover our delicious offerings</p>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Categories Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="index.php?action=menu" class="block px-3 py-2 rounded-md <?php echo !isset($_GET['category']) ? 'bg-orange-100 text-orange-600 font-medium' : 'text-gray-600 hover:bg-gray-50'; ?> smooth-transition">
                                All Items
                            </a>
                        </li>
                        <?php foreach($categories as $category): ?>
                            <li>
                                <a href="index.php?action=menu&category=<?php echo $category['id']; ?>" class="block px-3 py-2 rounded-md <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'bg-orange-100 text-orange-600 font-medium' : 'text-gray-600 hover:bg-gray-50'; ?> smooth-transition">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Menu Items Grid -->
            <div class="flex-grow">
                <?php if(empty($items)): ?>
                    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                        <p class="text-xl text-gray-500">No items found in this category.</p>
                    </div>
                <?php else: ?>
                    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                        <?php foreach($items as $item): ?>
                            <div class="bg-white overflow-hidden shadow-sm rounded-2xl group hover:shadow-xl smooth-transition border border-gray-100 flex flex-col">
                                <div class="relative h-48 overflow-hidden flex-shrink-0">
                                    <?php $imgSrc = !empty($item['image']) ? "assets/images/" . $item['image'] : "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"; ?>
                                    <img class="w-full h-full object-cover group-hover:scale-110 smooth-transition duration-500" src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <?php if($item['category_name']): ?>
                                        <div class="absolute top-0 left-0 mt-4 ml-4 bg-orange-500 text-white px-2 py-1 rounded text-xs font-bold shadow-sm">
                                            <?php echo htmlspecialchars($item['category_name']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-5 flex-grow flex flex-col">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight"><?php echo htmlspecialchars($item['name']); ?></h3>
                                        <span class="text-lg font-black text-orange-500 ml-2"><?php echo number_format($item['price'], 2); ?> SAR</span>
                                    </div>
                                    <p class="text-gray-500 text-sm mb-4 flex-grow"><?php echo htmlspecialchars($item['description']); ?></p>
                                    
                                    <a href="index.php?action=add_to_cart&id=<?php echo $item['id']; ?>" class="w-full block text-center py-2 px-4 border border-orange-500 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white font-medium smooth-transition">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
