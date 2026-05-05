# Class Analysis

## Identified Classes
Based on the PHP MVC routing structure and controller implementations found in the `app/controllers` and `app/config` directories.

* **Database**: Handles PDO connection to MySQL.
* **AuthController**: Manages login, registration, and logout logic.
* **HomeController**: Handles the landing page rendering.
* **MenuController**: Handles displaying categories and food items.
* **CartController**: Manages adding, removing, updating, and displaying the shopping cart.
* **OrderController**: Manages checkout, order finalization, and order history viewing.
* **AdminController**: Secures admin routes and processes all admin operations (CRUD for menu, updates for orders, deletes for users).

## Mermaid Class Diagram

```mermaid
classDiagram
    class Database {
        -host : string
        -db_name : string
        -username : string
        -password : string
        -conn : PDO
        +getConnection() PDO
    }

    class AuthController {
        -db : PDO
        +login() void
        +register() void
        +logout() void
    }

    class HomeController {
        -db : PDO
        +index() void
    }

    class MenuController {
        -db : PDO
        +index() void
    }

    class CartController {
        -db : PDO
        -getCartId(user_id: int) int
        -updateCartCount(user_id: int) void
        +index() void
        +add() void
        +update() void
        +remove() void
    }

    class OrderController {
        -db : PDO
        +checkout() void
        +placeOrder() void
        +success() void
        +history() void
    }

    class AdminController {
        -db : PDO
        -checkAdmin() void
        +dashboard() void
        +users() void
        +menu() void
        +addFood() void
        +deleteFood() void
        +orders() void
        +updateOrderStatus() void
    }

    AuthController --> Database : uses
    HomeController --> Database : uses
    MenuController --> Database : uses
    CartController --> Database : uses
    OrderController --> Database : uses
    AdminController --> Database : uses
```
