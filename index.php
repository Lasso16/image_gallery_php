<?php

use dwes\app\exceptions\AppException;
use dwes\core\App;
use dwes\core\Request;
use dwes\app\exceptions\NotFoundException;

try {
    require_once 'core/bootstrap.php';
    App::get('router')->direct(Request::uri(), Request::method());
} catch (AppException $appException) {
    $appException->handleError();
}