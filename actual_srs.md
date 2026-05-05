# 📄 Software Requirements Specification (SRS)

## 1. Introduction
* **Purpose of the system:** To provide an online food ordering platform for a single restaurant ("Bisha Restaurant"), allowing customers to browse a menu, place orders, and track them, while providing an admin panel to manage the menu, users, and order processing.
* **Scope:** The current system enables user registration, menu browsing by category, cart management, checking out via Cash on Delivery, order tracking via an order history page, and an administrative backend for managing menu items, users, and order statuses.
* **Definitions:**
  * **Customer:** A registered user who can browse the menu and place orders.
  * **Admin:** A privileged user responsible for managing the system.
  * **SAR:** Saudi Riyal, the default currency configured in the system.

---

## 2. Overall Description

### 2.1 System Overview
The system is built as a monolithic web application using PHP and MySQL, following a custom clean MVC routing pattern. The frontend utilizes HTML5 and TailwindCSS (via CDN). It is strictly designed to operate for a single restaurant (Bisha Restaurant), meaning all food items and categories globally belong to this single entity.

### 2.2 User Roles
1. **Customer:** Can browse the menu, manage their shopping cart, place orders via Cash on Delivery (COD), and view their personal order history.
2. **Admin:** Can view dashboard statistics, delete customer accounts, add/delete menu items, and update order statuses.

### 2.3 Assumptions & Dependencies
* The system relies on a local/server environment equipped with PHP and MySQL (e.g., XAMPP).
* TailwindCSS and FontAwesome rely on an active internet connection (CDN delivery).
* The currency is hardcoded to SAR across all views.
* The application is served from a specific directory (`htdocs/foodordering`).

---

## 3. Functional Requirements (FR)

**FR1: User Authentication**
* **Description:** Users can register a new account, login securely, and logout.
* **Inputs:** Full Name, Email, Password.
* **Outputs:** Secure session creation, redirection to Home or Admin Dashboard depending on role.
* **Process:** Validates input, hashes the password using bcrypt (`password_hash()`), stores it in the `users` table, and verifies it during login using `password_verify()`.
* **Related files/components:** `AuthController.php`, `login.php`, `register.php`.

**FR2: Menu Browsing**
* **Description:** Customers can view available food items, with the option to filter them by category.
* **Inputs:** Category ID (optional GET parameter).
* **Outputs:** Display of food items with an image, price (SAR), category name, and description.
* **Process:** Queries the `food_items` and `categories` tables using PDO.
* **Related files/components:** `MenuController.php`, `menu.php`, `HomeController.php`.

**FR3: Cart Management**
* **Description:** Customers can add items to their cart, update item quantities, and remove items.
* **Inputs:** Item ID, Quantity.
* **Outputs:** Updated cart subtotal, delivery fee, and final total UI.
* **Process:** Persists the cart state into the `carts` and `cart_items` database tables based on the user's active session ID.
* **Related files/components:** `CartController.php`, `cart.php`.

**FR4: Order Placement**
* **Description:** Customers can finalize their cart and place an order using Cash on Delivery.
* **Inputs:** Delivery Address, Payment Method (locked to Cash on Delivery).
* **Outputs:** Order Confirmation page and unique Order ID.
* **Process:** Calculates the total + delivery fee (5.00 SAR), moves items from `cart_items` to `order_items`, records the order in the `orders` and `payments` tables within a strict MySQL Transaction, and clears the cart.
* **Related files/components:** `OrderController.php`, `checkout.php`, `order_success.php`.

**FR5: Order History and Tracking**
* **Description:** Customers can view their past orders and track their current order statuses.
* **Inputs:** User ID (fetched via secure session).
* **Outputs:** A list of orders showing the total price, date, and status pill (Pending, Preparing, Delivered, Cancelled).
* **Process:** Retrieves orders descending by date for the logged-in user from the `orders` table.
* **Related files/components:** `OrderController.php`, `order_history.php`.

**FR6: Admin Dashboard & User Management**
* **Description:** Admins can view high-level statistics and delete customer accounts.
* **Inputs:** User ID to delete (via GET parameter).
* **Outputs:** Dashboard metrics (Total Users, Total Revenue, Total Orders, Menu Items).
* **Process:** Executes `COUNT` and `SUM` aggregation queries on relevant tables. Deletes users directly from the `users` table.
* **Related files/components:** `AdminController.php`, `admin/dashboard.php`, `admin/users.php`.

**FR7: Admin Menu Management**
* **Description:** Admins can add new food items (with image uploads) and delete existing ones.
* **Inputs:** Name, Category, Price, Description, Image File.
* **Outputs:** An updated menu list table.
* **Process:** Uploads the image to `public/assets/images/`, and performs INSERT/DELETE queries on `food_items`.
* **Related files/components:** `AdminController.php`, `admin/menu.php`.

**FR8: Admin Order Management**
* **Description:** Admins can view all placed orders system-wide and update their statuses.
* **Inputs:** Order ID, New Status (Dropdown selection).
* **Outputs:** Updated global order list.
* **Process:** Updates the `status` column in the `orders` table via a POST request.
* **Related files/components:** `AdminController.php`, `admin/orders.php`.

---

## 4. Non-Functional Requirements (NFR)

* **Performance:** The system uses a lightweight custom MVC pattern resulting in fast server-side HTML rendering. Database queries utilize indexes inherently created via Primary/Foreign keys.
* **Security:** 
  * Passwords are encrypted securely using bcrypt. 
  * Basic SQL injection protection is implemented universally via PDO prepared statements (`bindParam`). 
  * *Unclear / يحتاج توضيح:* There is currently no CSRF (Cross-Site Request Forgery) token protection implemented for forms.
* **Usability:** The UI utilizes TailwindCSS to guarantee a fully responsive, mobile-first design. It incorporates modern CSS transitions and hover states for better UX.
* **Reliability:** The system uses a MySQL Transaction (`beginTransaction()`, `commit()`, `rollBack()`) during the critical "Order Placement" step to ensure data consistency in case of a crash or failure mid-insert.

---

## 5. System Models 

### Basic Customer Flow
1. User logs in or registers an account.
2. User navigates to the Menu and clicks "Add to Cart" on desired items.
3. User navigates to the Cart, adjusts quantities, and clicks "Proceed to Checkout".
4. User selects "Cash on Delivery", inputs their address, and confirms the order.
5. User lands on the Order Success page and later checks "My Orders" to monitor status updates.

---

## 6. Limitations

* **Payment Processing:** Online payment is completely non-functional. The UI explicitly shows the "Online Payment" radio button as disabled.
* **Single Tenant Architecture:** The database schema inherently does not support multiple restaurants. There is no `restaurants` table; all items belong to Bisha Restaurant.
* **Notifications:** The system does not send real-time push, email, or SMS notifications. Tracking is strictly passive (user must refresh the page).
* **Menu Editing:** Admins can add and delete food items, but an "Edit existing item" function is currently missing.
* **Hardcoded Values:** The Delivery fee is hardcoded directly to `5.00` in both `CartController.php` and `OrderController.php`.

---

## 7. Future Improvements (Optional)

* **Suggestion 1:** Implement an actual payment gateway API (e.g., Stripe, PayPal) to enable secure credit card transactions.
* **Suggestion 2:** Implement PHPMailer to trigger automated order confirmation emails upon successful checkout.
* **Suggestion 3:** Add an "Edit Food Item" feature in the Admin panel to prevent the need to delete and recreate items for simple price/name tweaks.
* **Suggestion 4:** Introduce a `system_settings` table in the database to manage variables like the Delivery Fee dynamically from the Admin Dashboard instead of modifying PHP files.
* **Suggestion 5:** Implement CSRF tokens for all state-changing POST requests (like adding to cart, updating statuses) to enhance security.
