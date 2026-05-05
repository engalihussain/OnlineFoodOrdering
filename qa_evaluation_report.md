# 📊 Project vs SRS Evaluation Report

## 📌 Summary

* Total Requirements: 10 (Evaluated based on core Functional and Non-Functional SRS specs)
* Fully Implemented: 5
* Partially Implemented: 4
* Not Implemented: 1
* Overall Compliance: 70%

---

## ✅ Fully Implemented Requirements

* **FR1: Account Registration**
  * Description: The system shall allow users to register accounts.
  * Evidence from project: `register.php` and `AuthController.php` handle user registration.
  * Notes: Successfully inserts user data into the database with basic validation.

* **FR2: Secure Login/Logout**
  * Description: The system shall support secure login and logout.
  * Evidence from project: `login.php` and `AuthController.php` manage PHP sessions securely.
  * Notes: Includes role-based access control (Admin vs Customer).

* **FR4: Cart Management**
  * Description: Users shall be able to add or remove food items from the cart.
  * Evidence from project: `cart.php` and `CartController.php` allow adding, updating quantity, and removing items.
  * Notes: Fully functional; correctly persists to the `cart_items` database table.

* **FR7: Menu Management**
  * Description: Restaurants shall update food menus and prices.
  * Evidence from project: `admin/menu.php` allows the admin to add, price, upload images for, and delete menu items.
  * Notes: Administrator currently acts as the restaurant manager.

* **NFR4: Usability**
  * Description: User-friendly and responsive interface.
  * Evidence from project: The entire UI is built with TailwindCSS, ensuring responsive layouts across devices.
  * Notes: The interface is modern, clean, and features smooth CSS transitions.

---

## ⚠️ Partially Implemented Requirements

* **FR3: Display Restaurant Lists and Menus**
  * Description: The system shall display restaurant lists and menus.
  * Missing parts: Only a single restaurant (Bisha Restaurant) is supported. There is no list of multiple restaurants to browse.
  * Evidence: Hardcoded single restaurant layout. Database schema lacks a `restaurants` table.
  * Recommendation: Create a `restaurants` table and link `food_items` to specific restaurants to support a true multi-vendor platform.

* **FR6: Order Status Notifications**
  * Description: Customers shall receive order status notifications.
  * Missing parts: Active notifications (Email, SMS, or Push) are completely missing.
  * Evidence: Users must manually navigate to the "Order History" page to track their order status.
  * Recommendation: Integrate an email service API (like PHPMailer or SendGrid) to send order confirmation and status update emails dynamically.

* **FR8: Administrator Management**
  * Description: Administrators shall manage users, restaurants, and reports.
  * Missing parts: No multi-restaurant management (due to single-tenant design) and no exportable/detailed reports.
  * Evidence: The dashboard only shows high-level statistics (total users, revenue, orders) and allows deleting users.
  * Recommendation: Add a feature to generate PDF/CSV reports and implement multi-restaurant management panels.

* **NFR2: Security**
  * Description: Password encryption and secure payment gateway integration.
  * Missing parts: Payment gateway is completely missing.
  * Evidence: Passwords are encrypted successfully using bcrypt (`password_hash`), satisfying the first half of the requirement. No payment gateway exists.
  * Recommendation: Implement Stripe or PayPal APIs to fulfill the payment security requirement.

---

## ❌ Not Implemented Requirements

* **FR5: Online Payments**
  * Description: The system shall support online payments.
  * Why it's missing: The checkout system currently only processes "Cash on Delivery". The UI displays an "Online Payment" option, but it is explicitly disabled/mocked.
  * Recommendation: Integrate a payment processing API (e.g., Stripe, Razorpay) in `checkout.php` and `OrderController.php` to accept credit cards securely.

---

## 🚀 Recommendations

1. **Architectural Shift:** Update the database schema to include a `restaurants` table. Adjust models and controllers to support a multi-vendor marketplace, as the SRS explicitly requires browsing "restaurant lists".
2. **Payment Integration:** Implement Stripe or PayPal to handle online transactions safely, replacing the mock disabled radio button on the checkout page.
3. **Active Notifications:** Use an email delivery API to notify customers when an admin changes their order status from 'Pending' to 'Preparing' or 'Delivered'.
4. **Reporting Tools:** Add export features (CSV/Excel/PDF) to the Admin Dashboard to allow downloading of comprehensive sales reports.
