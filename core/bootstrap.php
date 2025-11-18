<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
use dwes\core\App;
use dwes\core\Router;
use dwes\app\utils\MyLog;
use dwes\app\repository\UsuarioRepository;

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);

$router = Router::load(__DIR__ . '/../app/' . $config['routes']['filename']);
App::bind('router',$router);

$logger = MyLog::load(__DIR__ . '/../logs/' . $config['logs']['filename'], $config['logs']['level']);
App::bind('logger',$logger);

if (isset($_SESSION['loguedUser'])) {
    $appUser = App::getRepository( UsuarioRepository::class)->find($_SESSION['loguedUser']);
} else {$appUser = null;}

App::bind('appUser', $appUser);