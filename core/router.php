<?php
class Router
{
    private $routes;

    private function __construct()
    {
        $this->routes = [];
    }
    /**
     * @param string $file
     * @return Router
     */
    public static function load(string $file): Router
    {
        $router = new Router();
        require $file;
        return $router;
    }
    /**
     * @param array $routes
     * @return void
     */
    public function define(array $routes): void
    {
        $this->routes = $routes;
    }
    /**
     * Summary of direct
     * @param string $uri
     * @throws \NotFoundException
     * @return string
     */
    public function direct(string $uri): string
    {
        if (array_key_exists($uri, $this->routes))
            return $this->routes[$uri];
        throw new NotFoundException("No se ha definido una ruta para la uri solicitada");
    }
}
