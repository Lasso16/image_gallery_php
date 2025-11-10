<?php
require_once __DIR__ . '/../src/exceptions/AppException.class.php';
require_once __DIR__ . '/../src/database/Connection.class.php';



class App
{
    /**
     * @var array
     */
    private static $container = [];
    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public static function bind(string $key, $value)
    {
        static::$container[$key] = $value;
    }
    /**
     * @param string $key
     * @return mixed
     * @throws AppException
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$container))
            throw new AppException("No se ha encontrado la clave $key en el contenedor");
        return static::$container[$key];
    }
    /**
     * @return PDO
     */
    public static function getConnection()
    {
        if (!array_key_exists('connection', static::$container))
            static::$container['connection'] = Connection::make();
        return static::$container['connection'];
    }
}
$cfg = require __DIR__ . '/../app/config.php';

App::bind('config', require __DIR__ . '/../app/config.php');