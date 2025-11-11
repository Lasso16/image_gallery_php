<?php
use dwes\core\App;
use dwes\core\Request;
use dwes\app\exceptions\NotFoundException;

try {
    require_once 'core/bootstrap.php';
    require App::get('router')->direct(Request::uri(), Request::method());
} catch (NotFoundException $e) {
    die($e->getMessage());
}