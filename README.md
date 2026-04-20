# DWES Local Project

Web platform developed in PHP for managing:
* **Image Gallery** (views, likes, downloads)
* **Exhibitions** (selection of images for events/collections)
* **Associates / Partners**
* **User Registration and Authentication** with roles and access control

Includes a custom router, template system with PHP views, repository layer over PDO, log management with Monolog, session control, and auxiliary utilities.

## Index
1. General Description
2. Main Features
3. Architecture and Request Flow
4. Directory Structure
5. Data Model and Entities
6. Security and Role System
7. Routing
8. Controllers
9. Repositories and Data Access
10. Views and Rendering
11. Logs
12. Configuration
13. Installation and Setup
14. Usage Examples
15. Error and Exception Handling
16. Available Utilities
17. Extending the Project
18. Initial SQL Script
19. Requirements
20. License
21. Suggested Next Steps

---

## 1. General Description
The project implements an educational mini-framework to organize a gallery and exhibition site with role-based access control. It avoids using large frameworks (Laravel / Symfony) to demonstrate fundamental concepts: routing, service container, repositories, entities, view rendering, and security.

## 2. Main Features
* Router with support for dynamic parameters (`:id`) and role control.
* Dependency container (`App`) and centralized configuration loading.
* Repositories for data access and basic CRUD operations.
* View system with layout and main content (rendered with `Response::renderView`).
* User authentication and hierarchical roles (`ROLE_ADMIN > ROLE_USER > ROLE_ANONYMOUS`).
* Logging via Monolog wrapped by the `MyLog` utility class.
* Session management and current user linked to the container.
* Simplified Active Record pattern for entities (mapping to arrays for inserts/updates).

## 3. Architecture and Request Flow
1. The user accesses a URL via the browser.
2. `index.php` loads `core/bootstrap.php`.
3. **`bootstrap.php`**:
   * Starts the session (`session_start`).
   * Loads Composer autoload.
   * Loads configuration (`app/config.php`) and binds it to the container (`App::bind`).
   * Builds the router by loading `app/routes.php`.
   * Configures the logger.
   * Resolves the authenticated user (if exists in session) and binds them (`appUser`).
4. The router (`Router::direct`) compares the URI with registered routes and verifies roles.
5. If the route requires authentication and is not met, it throws an `AuthenticationException` or redirects to `login`.
6. The controller is instantiated and the action is executed.
7. The action invokes repositories / logic and finally renders views using `Response::renderView` (injects data and composes layout + view).

## 4. Directory Structure (Summary)
```text
app/
  config.php              Main configuration
  routes.php              Route definitions
  controllers/            Action logic
  entity/                 Domain entities
  exceptions/             Custom exceptions
  repository/             Repositories (DAO)
  utils/                  Utilities (captcha, logs, etc.)
  views/                  Views and layouts
core/
  App.php                 Container / service locator
  bootstrap.php           Environment initialization
  Router.php              Routing and dispatch
  Request.php             URI and method utilities
  Response.php            View rendering
  Security.php            Roles and encryption
  database/               Connection and QueryBuilder
public/                   Static assets (CSS, JS, images)
logs/                     Log files
vendor/                   Composer dependencies (Monolog)
```


## 5. Data Model and Entities
Tables (see `cursophp.sql`):
* `usuarios`: credentials and role.
* `imagenes`: image metadata (views, likes, downloads, category, author user).
* `categorias`: image classification.
* `asociados`: partners associated with the project.
* `exposiciones`: events or collections created by users.
* `imagen_exposicion`: N:M bridge table between images and exhibitions.

Entity example (`Usuario`):
```php
class Usuario implements IEntity {
  private $id; private string $username; private string $password; private string $role;
  public function toArray(): array { return ['id'=>$this->id,'username'=>$this->username,'role'=>$this->role,'password'=>$this->password]; }
}
```
Entities expose `toArray()` for building parameterized statements in `QueryBuilder::save` and `QueryBuilder::update`.

## 6. Security and Role System
Definition in `app/config.php`:
```php
'roles' => [
  'ROLE_ADMIN' => 3,
  'ROLE_USER' => 2,
  'ROLE_ANONYMOUS' => 1
]
```

`Security::isUserGranted($role)` compares hierarchical values. Actions requiring a role are defined in each route. Password encryption: `password_hash` (BCRYPT) and verification with `password_verify`.

## 7. Routing
Registration in `app/routes.php` via:
```php
$router->get('galeria/:id', 'GaleriaController@show', 'ROLE_USER');
```

Dynamic parameters use the `:name` syntax and are transformed into named groups (`(?<name>[^/]+)`).
Internal flow:
* Route preparation: `prepareRoute()`.
* Parameter extraction: `getParametersRoute()`.
* Controller resolution: class name + method separated by `@`.
* Role verification before execution.

## 8. Controllers (Brief List)
* `PagesController`: public pages (`index`, `about`, `blog`).
* `AuthController`: login, registration, logout.
* `GaleriaController`: CRUD/image visualization.
* `ExposicionesController`: creation and listing of exhibitions.
* `ImagenExposicionController`: associating images with exhibitions.
* `AsociadosController`: partner management.
* `ContactoController`: contact form.

## 9. Repositories and Data Access
Each repository extends (directly or indirectly) `QueryBuilder`, providing table and entity context. Key functions:
* `findAll()`, `find(id)`, `findBy(filters)`, `findOneBy(filters)`.
* `save(IEntity $e)` inserts dynamically.
* `update(IEntity $e)` generates assignments with `getUpdates`.
* `executeTransaction(callable)` allows for atomic operations.

Typical usage:
```php
$repo = App::getRepository(ImagenRepository::class);
$imagenes = $repo->findAll();
$imagen = $repo->find(15);
```


## 10. Views and Rendering
`Response::renderView($name, $layout, $data)`:
* Extracts `$data` into variables.
* Captures content from `views/<name>.view.php` in a buffer.
* Embeds it within the defined layout (`layout.view.php` or variations with footer).
Reusable partials can be created in `views/*.part.php`.

## 11. Logs
Configuration in `config.php` (`curso.log`, level `WARNING`).
`MyLog::load(path, level)` initializes Monolog with suitable handlers. The logger is stored as the `logger` service in the container and can be used as follows:
```php
App::get('logger')->warning('Test message');
```


## 12. Configuration
`app/config.php` centralizes:
* PDO connection data (`name`, `username`, `password`).
* Routes file.
* Project base namespace.
* Roles and levels.
* Log level.
Change DB credentials and log level according to the environment (development / production).

## 13. Installation and Setup
Prerequisites: XAMPP / LAMP with MySQL and PHP >= 8.1 (8.2 recommended).

Steps:
1. Clone or copy the project into `htdocs` (XAMPP).
2. Import `cursophp.sql` in phpMyAdmin, creating the `cursophp` database.
3. Create MySQL user `usercurso` with password `php` and privileges over `cursophp`.
4. Adjust credentials in `app/config.php` if necessary.
5. Install dependencies (if not present): `composer install`.
6. Access via browser: `http://localhost/proyectos/dwes.local/`.

## 14. Usage Examples
Add a new protected route:
```php
// app/routes.php
$router->get('admin/panel', 'AdminController@index', 'ROLE_ADMIN');
```

New controller:
```php
namespace dwes\app\controllers;
use dwes\core\Response;
class AdminController {
  public function index() { Response::renderView('admin-panel', 'layout', ['title'=>'Panel']); }
}
```

Save entity:
```php
$usuario = new Usuario();
$usuario->setUsername('new');
$usuario->setPassword(Security::encrypt('secret'));
$usuario->setRole('ROLE_USER');
App::getRepository(UsuarioRepository::class)->save($usuario);
```

Role verification:
```php
if (!Security::isUserGranted('ROLE_ADMIN')) { throw new AuthenticationException('Admin only'); }
```


## 15. Error and Exception Handling
Custom exceptions in `app/exceptions/`:
* `AppException`: generic base.
* `AuthenticationException`: unauthorized access.
* `NotFoundException`: non-existent resource or route.
* `QueryException`: SQL execution errors.
* `ValidationException`, `FileException`, etc., for specific cases.
Best practice: catch exceptions in controllers and render `error.view.php` with a clear message.

## 16. Available Utilities
* `Utils::extraeElementosAleatorios($lista, $cantidad)` for random samples.
* `Utils::esOpcionMenuActiva($opcion)` marks active navigation.
* `captcha.php`: visual challenge generation (according to local implementation).
* `File.php`: upload / validation operations (check file for details).
* `MyLog`: simplified Monolog wrapper.

## 17. Extending the Project
* New roles: add a key in `security.roles` with a hierarchical value.
* New entities: create a class in `app/entity`, a repository in `app/repository` extending `QueryBuilder`, and update the SQL script.
* Middleware: logic could be added before `callAction` in the `Router`.
* Cache: add a service in `bootstrap.php` and bind it to the container.

## 18. Initial SQL Script
The `cursophp.sql` file includes:
* Table creation.
* Example inserts (users, images, categories, associates).
* Indexes and foreign keys with `ON DELETE CASCADE` for automatic cleanup.
Import this to have test data available immediately.

## 19. Requirements
* PHP: >= 8.1 (8.2 is ideal for compatibility with the server shown).
* PDO MySQL extension enabled.
* Composer to manage Monolog.
* HTTP Server (Apache in XAMPP or similar).

Composer dependencies:
```json
{
  "require": { "monolog/monolog": "^3.9" },
  "autoload": { "psr-4": { "dwes\\": "" } }
}
```


## 20. License
No license has been specified. Add a license section (e.g., MIT) if it will be publicly distributed.

## 21. Suggested Next Steps
* Add unit tests (PHPUnit) for repositories and critical controllers.
* Implement centralized validations and input sanitization.
* Add CSRF tokens for POST forms.
* Internationalization (i18n) with language files.
* Refactor views to a template engine (Twig) if more flexibility is required.
* Improve pagination and filters for large listings (images, exhibitions).

---
## Questions / Support
For doubts or improvements, document issues internally or prepare a `CONTRIBUTING.md` file if development is opened.

---
## Note
This README is a complete guide intended for developers who wish to understand, run, and extend the project quickly.
