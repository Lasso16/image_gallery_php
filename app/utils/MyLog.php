<?php
namespace dwes\app\utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class MyLog
{
    /**
     * @var Logger
     */
    private $log;
    
    private $level;
    private function __construct(string $filename, int $level)
    {
        $this->level = $level;
        $this->log = new Logger('name');
        $this->log->pushHandler(new StreamHandler($filename, $this->level));
    }
    public static function load(string $filename, int $level = Logger::INFO): MyLog
    {
        return new MyLog($filename, $level);
    }
    public function add(string $message): void
    {
        $this->log->log($this->level, $message);
    }
}
