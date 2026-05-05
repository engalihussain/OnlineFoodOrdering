-- seed.sql
-- Dummy data for Bisha Restaurant Online Food Ordering System
-- Password for all seeded users is: password

-- Disable foreign key checks to avoid issues during truncation and seeding
SET FOREIGN_KEY_CHECKS = 0;

-- Truncate existing tables to start fresh (Optional: Comment out if you want to keep existing data)
DELETE FROM `payments`;
ALTER TABLE `payments` AUTO_INCREMENT = 1;
DELETE FROM `order_items`;
ALTER TABLE `order_items` AUTO_INCREMENT = 1;
DELETE FROM `orders`;
ALTER TABLE `orders` AUTO_INCREMENT = 1;
DELETE FROM `cart_items`;
ALTER TABLE `cart_items` AUTO_INCREMENT = 1;
DELETE FROM `carts`;
ALTER TABLE `carts` AUTO_INCREMENT = 1;
DELETE FROM `food_items`;
ALTER TABLE `food_items` AUTO_INCREMENT = 1;
DELETE FROM `categories`;
ALTER TABLE `categories` AUTO_INCREMENT = 1;
DELETE FROM `users`;
ALTER TABLE `users` AUTO_INCREMENT = 1;

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ==============================================
-- 1. Seed Users 
-- ==============================================
-- Standard bcrypt hash for 'password' is used here
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@foodordering.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW()),
(2, 'John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW()),
(3, 'Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW());

-- ==============================================
-- 2. Seed Categories
-- ==============================================
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Main Courses', 'Hearty and delicious main dishes.'),
(2, 'Appetizers', 'Starters to begin your meal.'),
(3, 'Desserts', 'Sweet treats to end your meal.'),
(4, 'Beverages', 'Refreshing drinks and juices.');

-- ==============================================
-- 3. Seed Food Items
-- ==============================================
INSERT INTO `food_items` (`id`, `category_id`, `name`, `description`, `price`, `image`) VALUES
(1, 1, 'Bisha Signature Grilled Chicken', 'Half grilled chicken marinated in our secret Bisha spices, served with garlic sauce and fries.', 35.00, ''),
(2, 1, 'Classic Beef Burger', 'Juicy beef patty with cheese, lettuce, tomato, and our special house sauce.', 25.00, ''),
(3, 1, 'Chicken Shawarma Plate', 'Authentic sliced chicken shawarma served with rice, salad, and garlic sauce.', 30.00, ''),
(4, 2, 'Hummus & Pita', 'Creamy traditional hummus drizzled with olive oil, served with fresh pita bread.', 15.00, ''),
(5, 2, 'Mozzarella Sticks', 'Crispy golden mozzarella sticks served with marinara dipping sauce.', 18.00, ''),
(6, 3, 'Chocolate Lava Cake', 'Warm chocolate cake with a gooey molten center.', 22.00, ''),
(7, 3, 'Kunafa', 'Traditional Middle Eastern sweet cheese pastry soaked in syrup.', 20.00, ''),
(8, 4, 'Fresh Orange Juice', 'Freshly squeezed sweet orange juice.', 12.00, ''),
(9, 4, 'Soft Drink', 'Choice of Cola, Sprite, or Fanta.', 5.00, '');

-- ==============================================
-- 4. Seed Carts & Cart Items (Active Carts)
-- ==============================================
INSERT INTO `carts` (`id`, `user_id`, `created_at`) VALUES
(1, 2, NOW());

INSERT INTO `cart_items` (`id`, `cart_id`, `item_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 4, 1),
(3, 1, 8, 2);

-- ==============================================
-- 5. Seed Orders
-- ==============================================
INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `delivery_address`, `created_at`) VALUES
(1, 2, 95.00, 'Delivered', '123 Main St, Apt 4B, Riyadh', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 3, 57.00, 'Preparing', '456 King Fahd Rd, Jeddah', DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(3, 2, 48.00, 'Pending', '123 Main St, Apt 4B, Riyadh', NOW());

-- ==============================================
-- 6. Seed Order Items
-- ==============================================
-- Order 1: 2x Grilled Chicken (70) + 1x Kunafa (20) + Delivery (5) = 95.00 SAR
INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 35.00),
(2, 1, 7, 1, 20.00);

-- Order 2: 1x Shawarma Plate (30) + 1x Lava Cake (22) + Delivery (5) = 57.00 SAR
INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(3, 2, 3, 1, 30.00),
(4, 2, 6, 1, 22.00);

-- Order 3: 1x Beef Burger (25) + 1x Mozzarella Sticks (18) + Delivery (5) = 48.00 SAR
INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(5, 3, 2, 1, 25.00),
(6, 3, 5, 1, 18.00);

-- ==============================================
-- 7. Seed Payments
-- ==============================================
INSERT INTO `payments` (`id`, `order_id`, `amount`, `method`, `status`, `created_at`) VALUES
(1, 1, 95.00, 'Cash on Delivery', 'Completed', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 2, 57.00, 'Cash on Delivery', 'Pending', DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(3, 3, 48.00, 'Cash on Delivery', 'Pending', NOW());
