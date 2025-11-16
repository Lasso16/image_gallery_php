<?php

require_once __DIR__ . '/../vendor/autoload.php';
use dwes\core\App;
use dwes\core\Router;
use dwes\app\utils\MyLog;

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);

$router = Router::load(__DIR__ . '/../app/' . $config['routes']['filename']);
App::bind('router',$router);

$logger = MyLog::load(__DIR__ . '/../logs/' . $config['logs']['filename'], $config['logs']['level']);
App::bind('logger',$logger);