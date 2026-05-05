# Sequence Diagrams

## Flow 1: Order Placement Flow
**Description**: The real sequence executed when a logged-in customer finalizes their cart and places an order via Cash on Delivery.

```mermaid
sequenceDiagram
    participant Customer
    participant OrderController
    participant Database

    Customer->>OrderController: POST /index.php?action=place_order (Address, COD)
    OrderController->>Database: Validate User Session
    Database-->>OrderController: Session Valid
    
    OrderController->>Database: SELECT cart_items
    Database-->>OrderController: Return Items & Total Price
    
    OrderController->>Database: beginTransaction()
    OrderController->>Database: INSERT INTO orders (Status: Pending)
    OrderController->>Database: INSERT INTO order_items
    OrderController->>Database: INSERT INTO payments (Status: Pending)
    OrderController->>Database: DELETE FROM cart_items (Clear cart)
    OrderController->>Database: commit()
    
    OrderController-->>Customer: Redirect to /index.php?action=order_success
```

## Flow 2: Authentication Flow (Login)
**Description**: The sequence executed when any user attempts to log into the system.

```mermaid
sequenceDiagram
    participant User
    participant AuthController
    participant Database

    User->>AuthController: POST /index.php?action=login (Email, Password)
    AuthController->>Database: SELECT id, password, role FROM users WHERE email = ?
    Database-->>AuthController: Return User Record
    
    alt Password verifies successfully
        AuthController->>Database: SELECT cart_count (if customer)
        Database-->>AuthController: Return count
        AuthController->>AuthController: Set $_SESSION variables
        
        alt Role == Admin
            AuthController-->>User: Redirect to Admin Dashboard
        else Role == Customer
            AuthController-->>User: Redirect to Home
        end
    else Invalid Password or Email
        AuthController-->>User: Render login.php with Error Message
    end
```
