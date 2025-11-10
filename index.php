<?php
require_once 'core/bootstrap.php';
$routes = require 'app/routes.php'; // Obtenemos la tabla de rutas
$uri = trim($_SERVER['REQUEST_URI'], '/'); // Obtenemos la uri del usuario
require $routes[$uri];
exit();