# Database Design

## Actual Database Tables
Extracted exactly from the `database.sql` schema and project models.

### `users`
* `id` (INT, PK, Auto Increment)
* `name` (VARCHAR)
* `email` (VARCHAR, Unique)
* `password` (VARCHAR)
* `role` (ENUM: 'customer', 'admin', Default: 'customer')
* `created_at` (TIMESTAMP)

### `categories`
* `id` (INT, PK, Auto Increment)
* `name` (VARCHAR)
* `description` (TEXT)

### `food_items`
* `id` (INT, PK, Auto Increment)
* `category_id` (INT, FK -> categories.id)
* `name` (VARCHAR)
* `description` (TEXT)
* `price` (DECIMAL 10,2)
* `image` (VARCHAR)

### `carts`
* `id` (INT, PK, Auto Increment)
* `user_id` (INT, FK -> users.id)
* `created_at` (TIMESTAMP)

### `cart_items`
* `id` (INT, PK, Auto Increment)
* `cart_id` (INT, FK -> carts.id)
* `item_id` (INT, FK -> food_items.id)
* `quantity` (INT, Default: 1)

### `orders`
* `id` (INT, PK, Auto Increment)
* `user_id` (INT, FK -> users.id)
* `total_price` (DECIMAL 10,2)
* `status` (ENUM: 'Pending', 'Preparing', 'Delivered', 'Cancelled', Default: 'Pending')
* `delivery_address` (TEXT)
* `created_at` (TIMESTAMP)

### `order_items`
* `id` (INT, PK, Auto Increment)
* `order_id` (INT, FK -> orders.id)
* `item_id` (INT, FK -> food_items.id)
* `quantity` (INT)
* `price` (DECIMAL 10,2)

### `payments`
* `id` (INT, PK, Auto Increment)
* `order_id` (INT, FK -> orders.id)
* `amount` (DECIMAL 10,2)
* `method` (VARCHAR, e.g., 'Cash on Delivery')
* `status` (VARCHAR, e.g., 'Pending')
* `created_at` (TIMESTAMP)

## Mermaid ER Diagram

```mermaid
erDiagram
    USERS ||--o{ CARTS : "owns"
    USERS ||--o{ ORDERS : "places"
    
    CATEGORIES ||--o{ FOOD_ITEMS : "contains"
    
    CARTS ||--o{ CART_ITEMS : "has"
    FOOD_ITEMS ||--o{ CART_ITEMS : "added_as"
    
    ORDERS ||--o{ ORDER_ITEMS : "includes"
    FOOD_ITEMS ||--o{ ORDER_ITEMS : "ordered_as"
    
    ORDERS ||--o| PAYMENTS : "paid_via"

    USERS {
        int id PK
        varchar name
        varchar email
        varchar password
        enum role
        timestamp created_at
    }

    CATEGORIES {
        int id PK
        varchar name
        text description
    }

    FOOD_ITEMS {
        int id PK
        int category_id FK
        varchar name
        text description
        decimal price
        varchar image
    }

    CARTS {
        int id PK
        int user_id FK
        timestamp created_at
    }

    CART_ITEMS {
        int id PK
        int cart_id FK
        int item_id FK
        int quantity
    }

    ORDERS {
        int id PK
        int user_id FK
        decimal total_price
        enum status
        text delivery_address
        timestamp created_at
    }

    ORDER_ITEMS {
        int id PK
        int order_id FK
        int item_id FK
        int quantity
        decimal price
    }

    PAYMENTS {
        int id PK
        int order_id FK
        decimal amount
        varchar method
        varchar status
        timestamp created_at
    }
```
