<?php

require_once 'core/bootstrap.php';

try {
    require \dwes\core\Router::load('app/routes.php')
        ->direct(\dwes\core\Request::uri(), \dwes\core\Request::method());
} catch (\dwes\app\exceptions\NotFoundException $e) {
    die($e->getMessage());
}