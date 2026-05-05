# Use Case Analysis

## Actors
* **Customer**: Registered user who can browse food, manage cart, and place orders.
* **Admin**: Privileged user who manages the system (users, menu, orders).

## Existing Use Cases

### Customer Use Cases
* **Register/Login**: Authenticate into the system securely.
* **Browse Menu**: View available food items and filter by categories.
* **Manage Cart**: Add items, update quantities, and remove items from the shopping cart.
* **Place Order**: Checkout using Cash on Delivery (Online Payment is disabled in UI).
* **Track Orders**: View order history and current status.

### Admin Use Cases
* **View Dashboard**: See aggregate statistics (users, revenue, orders).
* **Manage Users**: Delete customer accounts.
* **Manage Menu**: Add new food items (with image) and delete existing ones.
* **Manage Orders**: View incoming orders and update their statuses (Pending, Preparing, Delivered, Cancelled).

## Mermaid Use Case Diagram

```mermaid
usecaseDiagram
    actor Customer as "Customer"
    actor Admin as "Admin"

    package "Online Food Ordering System" {
        usecase "Register / Login" as UC1
        usecase "Browse Menu" as UC2
        usecase "Manage Cart" as UC3
        usecase "Place Order (COD)" as UC4
        usecase "View Order History" as UC5
        
        usecase "View Dashboard" as UC6
        usecase "Manage Users" as UC7
        usecase "Manage Menu Items" as UC8
        usecase "Update Order Status" as UC9
    }

    Customer --> UC1
    Customer --> UC2
    Customer --> UC3
    Customer --> UC4
    Customer --> UC5

    Admin --> UC1
    Admin --> UC6
    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
```
