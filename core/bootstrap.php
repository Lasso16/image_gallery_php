<?php

require_once __DIR__ . '/../vendor/autoload.php';
use dwes\core\App;
use dwes\core\Router;
use dwes\app\utils\MyLog;
use dwes\core\Request;


$config = require_once __DIR__ . '/../app/config.php';


App::bind('config', $config);

$router = Router::load('app/routes.php');
App::bind('router',$router);

$logger = MyLog::load('logs/curso.log');
App::bind('logger',$logger);