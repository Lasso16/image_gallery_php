# Proyecto DWES Local

Plataforma web desarrollada en PHP para la gestión de:
- Galería de imágenes (visualizaciones, likes, descargas)
- Exposiciones (selección de imágenes para mostrar en eventos/colecciones)
- Asociados / partners
- Registro y autenticación de usuarios con roles y control de acceso

Incluye un enrutador propio, sistema de plantillas con vistas PHP, capa de repositorios sobre PDO, gestión de logs con Monolog, control de sesiones y utilidades auxiliares.

## Índice
1. Descripción General
2. Características Principales
3. Arquitectura y Flujo de Petición
4. Estructura de Directorios
5. Modelo de Datos y Entidades
6. Seguridad y Sistema de Roles
7. Enrutamiento
8. Controladores
9. Repositorios y Acceso a Datos
10. Vistas y Renderizado
11. Logs
12. Configuración
13. Instalación y Puesta en Marcha
14. Ejemplos de Uso
15. Manejo de Errores y Excepciones
16. Utilidades Disponibles
17. Extender el Proyecto
18. Script SQL Inicial
19. Requisitos
20. Licencia
21. Próximos Pasos Sugeridos

---
## 1. Descripción General
El proyecto implementa un mini-framework educativo para organizar un sitio de galería y exposiciones con control de acceso basado en roles. Se evita el uso de frameworks grandes (Laravel / Symfony) para mostrar conceptos fundamentales: routing, contenedor de servicios, repositorios, entidades, renderizado de vistas y seguridad.

## 2. Características Principales
- Enrutador con soporte para parámetros dinámicos `:id` y control de roles.
- Contenedor de dependencias (`App`) y carga de configuración centralizada.
- Repositorios para acceso a datos y operaciones CRUD básicas.
- Sistema de vistas con layout y contenido principal (renderizado con `Response::renderView`).
- Autenticación de usuarios y roles jerárquicos (`ROLE_ADMIN > ROLE_USER > ROLE_ANONYMOUS`).
- Logging mediante Monolog envuelto por clase utilitaria `MyLog`.
- Gestión de sesiones y usuario actual enlazado al contenedor.
- Patrón Active Record simplificado para entidades (mapeo a arrays para inserts/updates).

## 3. Arquitectura y Flujo de Petición
1. El usuario accede vía navegador a una URL.
2. `index.php` carga `core/bootstrap.php`.
3. `bootstrap.php`:
   - Inicia sesión (`session_start`).
   - Carga autoload de Composer.
   - Carga configuración (`app/config.php`) y la vincula al contenedor (`App::bind`).
   - Construye el router cargando `app/routes.php`.
   - Configura el logger.
   - Resuelve el usuario autenticado (si existe en sesión) y lo vincula (`appUser`).
4. El enrutador (`Router::direct`) compara la URI con las rutas registradas y verifica roles.
5. Si la ruta requiere autenticación y no cumple, lanza `AuthenticationException` o redirige a `login`.
6. Se instancia el controlador y se ejecuta la acción.
7. La acción invoca repositorios / lógica y finalmente renderiza vistas usando `Response::renderView` (inyecta datos y compone layout + vista).

## 4. Estructura de Directorios (Resumen)
```
app/
  config.php              Configuración principal
  routes.php              Definición de rutas
  controllers/            Lógica de acciones
  entity/                 Entidades del dominio
  exceptions/             Excepciones personalizadas
  repository/             Repositorios (DAO)
  utils/                  Utilidades (captcha, logs, etc.)
  views/                  Vistas y layouts
core/
  App.php                 Contenedor / service locator
  bootstrap.php           Inicialización del entorno
  Router.php              Enrutamiento y dispatch
  Request.php             Utilidades para URI y método
  Response.php            Renderizado de vistas
  Security.php            Roles y cifrado
  database/               Conexión y QueryBuilder
public/                   Recursos estáticos (CSS, JS, imágenes)
logs/                     Archivos de log
vendor/                   Dependencias Composer (Monolog)
```

## 5. Modelo de Datos y Entidades
Tablas (ver `cursophp.sql`):
- `usuarios`: credenciales y rol.
- `imagenes`: metadatos de imágenes (visualizaciones, likes, descargas, categoría, usuario autor).
- `categorias`: clasificación de imágenes.
- `asociados`: partners asociados al proyecto.
- `exposiciones`: eventos o colecciones creadas por usuarios.
- `imagen_exposicion`: tabla puente N:M entre imágenes y exposiciones.

Entidad ejemplo (`Usuario`):
```php
class Usuario implements IEntity {
  private $id; private string $username; private string $password; private string $role;
  public function toArray(): array { return ['id'=>$this->id,'username'=>$this->username,'role'=>$this->role,'password'=>$this->password]; }
}
```
Las entidades exponen `toArray()` para construcción de sentencias parametrizadas en `QueryBuilder::save` y `QueryBuilder::update`.

## 6. Seguridad y Sistema de Roles
Definición en `app/config.php`:
```php
'roles' => [
  'ROLE_ADMIN' => 3,
  'ROLE_USER' => 2,
  'ROLE_ANONYMOUS' => 1
]
```
`Security::isUserGranted($role)` compara los valores jerárquicos. Acciones que requieren rol se definen en cada ruta. Cifrado de contraseñas: `password_hash` (BCRYPT) y verificación con `password_verify`.

## 7. Enrutamiento
Registro en `app/routes.php` mediante:
```php
$router->get('galeria/:id', 'GaleriaController@show', 'ROLE_USER');
```
Los parámetros dinámicos usan sintaxis `:nombre` y se transforman en grupos con nombre (`(?<nombre>[^/]+)`).
Flujo interno:
- Preparación de la regla: `prepareRoute()`.
- Extracción de parámetros: `getParametersRoute()`.
- Resolución de controlador: nombre de clase + método separados por `@`.
- Verificación de rol antes de ejecutar.

## 8. Controladores (Listado Breve)
- `PagesController`: páginas públicas (`index`, `about`, `blog`).
- `AuthController`: login, registro, logout.
- `GaleriaController`: CRUD/visualización de imágenes.
- `ExposicionesController`: creación y listado de exposiciones.
- `ImagenExposicionController`: asociación de imágenes a exposiciones.
- `AsociadosController`: gestión de partners.
- `ContactoController`: formulario de contacto.

## 9. Repositorios y Acceso a Datos
Cada repositorio extiende (directa o indirectamente) `QueryBuilder` proporcionando tabla y entidad. Funciones claves:
- `findAll()`, `find(id)`, `findBy(filters)`, `findOneBy(filters)`.
- `save(IEntity $e)` inserta dinámicamente.
- `update(IEntity $e)` genera asignaciones con `getUpdates`.
- `executeTransaction(callable)` permite operaciones atómicas.

Uso típico:
```php
$repo = App::getRepository(ImagenRepository::class);
$imagenes = $repo->findAll();
$imagen = $repo->find(15);
```

## 10. Vistas y Renderizado
`Response::renderView($name, $layout, $data)`:
- Extrae `$data` en variables.
- Captura contenido de `views/<name>.view.php` en buffer.
- Incrusta dentro del layout definido (`layout.view.php` o variantes con footer).
Se pueden crear partials en `views/*.part.php` reutilizables.

## 11. Logs
Configuración en `config.php` (`curso.log`, nivel `WARNING`).
`MyLog::load(ruta, nivel)` inicializa Monolog con handlers adecuados. El logger se guarda como servicio `logger` en el contenedor y puede usarse:
```php
App::get('logger')->warning('Mensaje de prueba');
```

## 12. Configuración
`app/config.php` centraliza:
- Datos de conexión PDO (`name`, `username`, `password`).
- Archivo de rutas.
- Namespace base del proyecto.
- Roles y niveles.
- Nivel de logs.
Cambiar credenciales de BD y nivel de logs según entorno (desarrollo / producción).

## 13. Instalación y Puesta en Marcha
Requisitos previos: XAMPP / LAMP con MySQL y PHP >= 8.1 (recomendado 8.2).

Pasos:
```bash
# 1. Clonar o copiar el proyecto en htdocs (XAMPP)
# 2. Importar 'cursophp.sql' en phpMyAdmin creando la BD 'cursophp'
# 3. Crear usuario MySQL 'usercurso' con password 'php' y privilegios sobre 'cursophp'
# 4. Ajustar si es necesario credenciales en app/config.php
# 5. Instalar dependencias (si no están): composer install
# 6. Acceder en navegador: http://localhost/proyectos/dwes.local/
```
Si Composer no está ejecutado, correr:
```bash
composer install
```

## 14. Ejemplos de Uso
Agregar nueva ruta protegida:
```php
// app/routes.php
$router->get('admin/panel', 'AdminController@index', 'ROLE_ADMIN');
```
Nuevo controlador:
```php
namespace dwes\app\controllers;
use dwes\core\Response;
class AdminController {
  public function index() { Response::renderView('admin-panel', 'layout', ['title'=>'Panel']); }
}
```
Guardar entidad:
```php
$usuario = new Usuario();
$usuario->setUsername('nuevo');
$usuario->setPassword(Security::encrypt('secreto'));
$usuario->setRole('ROLE_USER');
App::getRepository(UsuarioRepository::class)->save($usuario);
```
Verificación de rol:
```php
if (!Security::isUserGranted('ROLE_ADMIN')) { throw new AuthenticationException('Solo admin'); }
```

## 15. Manejo de Errores y Excepciones
Excepciones personalizadas en `app/exceptions/`:
- `AppException`: base genérica.
- `AuthenticationException`: acceso no autorizado.
- `NotFoundException`: recurso o ruta inexistente.
- `QueryException`: errores de ejecución SQL.
- `ValidationException`, `FileException`, etc. para casos concretos.
Buenas prácticas: capturar excepciones en controladores y renderizar `error.view.php` con mensaje claro.

## 16. Utilidades Disponibles
- `Utils::extraeElementosAleatorios($lista, $cantidad)` para muestras aleatorias.
- `Utils::esOpcionMenuActiva($opcion)` marca navegación activa.
- `captcha.php`: generación de desafío visual (según implementación local).
- `File.php`: operaciones de subida / validación (consultar archivo para detalles).
- `MyLog`: envoltorio simplificado de Monolog.

## 17. Extender el Proyecto
- Nuevos roles: añadir clave en `security.roles` con valor jerárquico.
- Nuevas entidades: crear clase en `app/entity`, repositorio en `app/repository` extendiendo `QueryBuilder` y actualizar script SQL.
- Middleware: podría añadirse lógica antes de `callAction` en `Router`.
- Cache: añadir servicio en `bootstrap.php` y vincularlo al contenedor.

## 18. Script SQL Inicial
El archivo `cursophp.sql` incluye:
- Creación de tablas.
- Inserts de ejemplo (usuarios, imágenes, categorías, asociados).
- Índices y claves foráneas con ON DELETE CASCADE para limpieza automática.
Importar para disponer de datos de prueba inmediatamente.

## 19. Requisitos
- PHP: >= 8.1 (ideal 8.2 por compatibilidad con servidor mostrado).
- Extensión PDO MySQL habilitada.
- Composer para gestionar Monolog.
- Servidor HTTP (Apache en XAMPP o similar).

Dependencias Composer:
```json
{
  "require": { "monolog/monolog": "^3.9" },
  "autoload": { "psr-4": { "dwes\\": "" } }
}
```

## 20. Licencia
No se ha especificado licencia. Añadir sección de licencia (ej. MIT) si se distribuirá públicamente.

## 21. Próximos Pasos Sugeridos
- Añadir pruebas unitarias (PHPUnit) para repositorios y controladores críticos.
- Implementar validaciones centralizadas y sanitización de entrada.
- Añadir CSRF tokens para formularios POST.
- Internacionalización (i18n) con archivos de idioma.
- Refactorizar vistas a un motor de plantillas (Twig) si se requiere más flexibilidad.
- Mejorar paginación y filtros en listados grandes (imágenes, exposiciones).

---
## Preguntas / Soporte
Para dudas o mejoras, documentar issues internamente o preparar un archivo CONTRIBUTING.md si se abre el desarrollo.

---
## Nota
Este README es una guía completa pensada para desarrolladores que deseen entender, ejecutar y extender el proyecto rápidamente.
