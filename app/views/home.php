<?php include '../app/views/layout/header.php'; ?>

<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Delicious food delivered</span>
                        <span class="block text-orange-500 xl:inline">straight to you</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Craving something extraordinary? Discover top-rated meals crafted by expert chefs. Fast delivery, fresh ingredients, and flavors that will make you return for more.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="index.php?action=menu" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-orange-500 hover:bg-orange-600 md:py-4 md:text-lg md:px-10 smooth-transition">
                                View Menu
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 mt-10 lg:mt-0">
        <!-- Will use a placeholder image for now, later we could generate one -->
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full rounded-l-3xl shadow-2xl" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80" alt="Delicious food">
    </div>
</div>

<!-- Featured Items -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-orange-500 font-semibold tracking-wide uppercase">Featured</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Our Popular Dishes
            </p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($featured_items as $item): ?>
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl group hover:shadow-xl smooth-transition">
                    <div class="relative h-48 overflow-hidden">
                        <?php $imgSrc = !empty($item['image']) ? "assets/images/" . $item['image'] : "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"; ?>
                        <img class="w-full h-full object-cover group-hover:scale-110 smooth-transition duration-500" src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="absolute top-0 right-0 mt-4 mr-4 bg-white px-3 py-1 rounded-full text-sm font-bold text-gray-900 shadow">
                            <?php echo number_format($item['price'], 2); ?> SAR
                        </div>
                    </div>
                    <div class="px-6 py-5">
                        <h3 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="mt-2 text-gray-500 text-sm line-clamp-2"><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="mt-4 flex items-center justify-between">
                            <a href="index.php?action=add_to_cart&id=<?php echo $item['id']; ?>" class="text-orange-500 hover:text-orange-600 font-medium flex items-center smooth-transition">
                                Add to Cart <i class="fas fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if(empty($featured_items)): ?>
                <p class="col-span-full text-center text-gray-500">No items available yet.</p>
            <?php endif; ?>
        </div>
        
        <div class="mt-12 text-center">
            <a href="index.php?action=menu" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 smooth-transition">
                View Full Menu
            </a>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
