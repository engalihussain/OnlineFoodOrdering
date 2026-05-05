# System Architecture

## Real Architecture Implemented
The application strictly follows a **Monolithic Custom MVC (Model-View-Controller)** pattern.
There is no modern frontend framework (like React/Vue) communicating via REST APIs. Instead, the backend PHP server renders HTML directly and serves it to the client.

## Key Components
1. **Frontend (View Layer)**:
   * Built with standard HTML5.
   * Styled entirely using **TailwindCSS** (served via CDN).
   * Interactivity (like mobile menus or simple UI toggles) handled by **Vanilla JavaScript**.
2. **Backend (Controller/Logic Layer)**:
   * Built in **Vanilla PHP** (No Laravel/Symfony framework).
   * Features a custom central routing mechanism located in `public/index.php`.
   * Controllers (`app/controllers/`) handle all business logic, session management, and database interactions.
3. **Database (Data Layer)**:
   * Relational database powered by **MySQL**.
   * Queried safely using PHP Data Objects (**PDO**) and prepared statements.

## Mermaid Architecture Diagram

```mermaid
architecture-beta
    group WebTier(cloud)[Client Browser]
    group ServerTier(server)[Web Server]
    group DatabaseTier(database)[Database Server]

    service UserBrowser(internet)[HTML/TailwindCSS UI] in WebTier
    
    service FrontController(server)[public/index.php Router] in ServerTier
    service Controllers(server)[PHP Controllers] in ServerTier
    service Views(server)[PHP View Templates] in ServerTier
    
    service MySQL(database)[MySQL Database] in DatabaseTier

    UserBrowser:R --> L:FrontController
    FrontController:R --> L:Controllers
    Controllers:R --> L:Views
    Views:R --> L:UserBrowser
    
    Controllers:B --> T:MySQL
```
