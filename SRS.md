# 📄 Software Requirements Specification (SRS)

## 1. Introduction

* **Purpose of the system:** The purpose of the Online Food Ordering System is to provide a digital platform for a restaurant ("Bisha Restaurant") to showcase its menu and allow customers to place food orders for delivery. It aims to streamline the ordering process, enhance the customer experience, and provide the restaurant administration with tools to manage orders and menu offerings efficiently.
* **Scope:** The system shall facilitate user registration, menu browsing by category, shopping cart management, order placement with multiple payment options (Cash on Delivery and Online Payment), order status tracking, and an administrative dashboard for managing customers, menu items, and incoming orders.
* **Definitions:**
  * **Customer:** An end-user who registers an account to browse the menu and place food orders.
  * **Administrator (Admin):** A privileged user responsible for managing the restaurant's digital menu, overseeing registered customers, and updating the status of placed orders.
  * **SAR:** Saudi Riyal, the designated currency for all transactions.
  * **COD:** Cash on Delivery.

---

## 2. Overall Description

### 2.1 System Overview
The Online Food Ordering System is a web-based application designed to bridge the gap between hungry customers and the restaurant kitchen. It provides a seamless, responsive storefront where customers can explore food categories, build a cart, and checkout securely. Simultaneously, it offers a backend portal for restaurant staff to monitor business metrics, adjust menu prices, upload dish images, and progress orders from "Pending" to "Delivered."

### 2.2 User Roles
* **Customer:** Registers for an account, browses the menu, manages a shopping cart, places orders, processes payments, and views their personal order history and tracking statuses.
* **Administrator:** Logs into a secure dashboard to view aggregate statistics, manage the menu catalog (Create, Read, Update, Delete), oversee customer accounts, and update the lifecycle status of all incoming orders.

### 2.3 Assumptions & Dependencies
* The system assumes users will access the platform via modern web browsers on desktop, tablet, or mobile devices.
* The system depends on a third-party payment gateway provider (e.g., Stripe, PayPal) for processing secure online credit card transactions.
* The system relies on an email delivery service (e.g., SendGrid, SMTP server) to send order confirmation and status update notifications to customers.

---

## 3. Functional Requirements (FR)

**FR1: User Registration and Authentication**
* **Description:** The system shall allow users to create an account, securely log in, and log out.
* **Inputs:** Full Name, Email Address, Password.
* **Outputs:** Successful authentication session and redirection to the appropriate dashboard based on user role.
* **Process:** The system validates the uniqueness of the email, securely hashes the password, stores the credentials, and establishes a secure session upon successful login.
* **Priority:** High

**FR2: Menu Catalog Management (Admin)**
* **Description:** The system shall allow administrators to create, read, update, and delete (CRUD) food items and categories.
* **Inputs:** Item Name, Category, Price (SAR), Description, and Image Upload.
* **Outputs:** An updated digital menu visible to all customers.
* **Process:** The system processes the image upload, validates input data, and persists the new or updated item to the database.
* **Priority:** High

**FR3: Menu Browsing and Filtering (Customer)**
* **Description:** The system shall display the restaurant's menu and allow customers to filter items by category.
* **Inputs:** Category selection filter.
* **Outputs:** A dynamically updated list of food items matching the selected category.
* **Process:** The system retrieves active menu items from the database and renders them in a user-friendly grid layout.
* **Priority:** High

**FR4: Shopping Cart Management**
* **Description:** The system shall allow customers to add items to a shopping cart, adjust item quantities, and remove items before checkout.
* **Inputs:** Add/Remove commands, Quantity numerical inputs.
* **Outputs:** A real-time updated cart interface displaying itemized costs, subtotal, delivery fee, and grand total.
* **Process:** The system calculates the total cost dynamically and persists the cart state securely across the user's session.
* **Priority:** High

**FR5: Order Placement and Checkout**
* **Description:** The system shall allow customers to finalize their cart and place an order using either Cash on Delivery or Secure Online Payment.
* **Inputs:** Delivery Address, Selected Payment Method, Credit Card details (if applicable).
* **Outputs:** A unique Order Confirmation Number and a success notification.
* **Process:** The system calculates final totals, processes payment via the integrated payment gateway (if online payment is selected), securely records the order details, and clears the user's shopping cart.
* **Priority:** High

**FR6: Order Status Management (Admin)**
* **Description:** The system shall allow administrators to view all incoming orders and update their statuses (e.g., Pending, Preparing, Delivered, Cancelled).
* **Inputs:** Status selection from a predefined dropdown list.
* **Outputs:** An updated order record and an automated email notification dispatched to the customer.
* **Process:** The system updates the order state in the database and triggers a notification workflow.
* **Priority:** High

**FR7: Customer Order Tracking**
* **Description:** The system shall allow customers to view their historical orders and track the real-time status of active orders.
* **Inputs:** User authentication session.
* **Outputs:** A chronological list of past and current orders displaying date, total cost, and current status.
* **Process:** The system retrieves order records associated specifically with the logged-in user account.
* **Priority:** Medium

**FR8: Administrative Dashboard and Analytics**
* **Description:** The system shall provide administrators with a dashboard displaying key business metrics.
* **Inputs:** Administrative session data.
* **Outputs:** Visual cards displaying Total Users, Total Revenue, Total Orders, and Total Menu Items.
* **Process:** The system aggregates data from various tables to provide real-time business insights.
* **Priority:** Medium

---

## 4. Non-Functional Requirements (NFR)

* **Performance:** The system shall load the main menu page in under 3 seconds on standard broadband connections to prevent user drop-off.
* **Security:** The system shall encrypt all user passwords using industry-standard hashing algorithms (e.g., bcrypt). All web traffic shall be forced over secure HTTPS. Online payments shall be fully PCI-DSS compliant by utilizing tokenized payment gateways.
* **Usability:** The system shall feature a fully responsive design, ensuring optimal viewing and interaction experiences across mobile phones, tablets, and desktop monitors.
* **Reliability:** The system shall guarantee data integrity during the checkout process by utilizing database transactions, ensuring orders are not lost during unexpected server interruptions.
* **Scalability:** The system architecture shall support concurrent usage by at least 500 active customers without severe performance degradation during peak dining hours.

---

## 5. System Models

### Expected User Flow: Order Placement
1. The Customer navigates to the web application.
2. The Customer registers for a new account or logs in.
3. The Customer browses the menu catalog and filters by "Main Course".
4. The Customer clicks "Add to Cart" on selected food items.
5. The Customer navigates to the Shopping Cart and verifies item quantities.
6. The Customer clicks "Proceed to Checkout" and enters their delivery address.
7. The Customer selects "Online Payment" and enters credit card details.
8. The system processes the payment securely.
9. The system generates an Order ID and displays the Order Success screen.
10. The Customer receives an automated order confirmation email.

---

## 6. Constraints

* **Technical Constraints:** The system must be hosted on a standard LAMP/LEMP stack (Linux, Apache/Nginx, MySQL, PHP) to align with standard hosting availability.
* **Business Constraints:** The platform is designed for a single-tenant restaurant structure and cannot be deployed as a multi-vendor marketplace without significant architectural redesign.
* **Regulatory Constraints:** The system must adhere to local data protection laws regarding the storage of customer email addresses and physical delivery addresses.

---

## 7. Future Enhancements (Optional)

* **Multi-Restaurant Support:** Transitioning the database and user roles to support a multi-vendor marketplace where various restaurants can register and sell food.
* **Real-time GPS Tracking:** Integrating mapping APIs (e.g., Google Maps) to allow customers to track the delivery driver's physical location in real-time.
* **Loyalty Program:** Implementing a points-based reward system where customers earn redeemable points for every SAR spent on the platform.
* **Advanced Analytics Export:** Providing administrators with the ability to generate and download comprehensive PDF or CSV sales reports by date range.
