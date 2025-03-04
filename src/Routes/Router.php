<?php

namespace App\Routes;

use App\Config\database;

class Router
{
    protected $routes = [];
    private $db;

    public function __construct(database $db)
    {
        $this->db = $db;
    }

    private function addRoute($route, $controller, $action, $method, $middleware = null)
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'middleware' => $middleware];
    }

    public function get($route, $controller, $action, $middleware = null)
    {
        $this->addRoute($route, $controller, $action, "GET", $middleware);
    }

    public function post($route, $controller, $action, $middleware = null)
    {
        $this->addRoute($route, $controller, $action, "POST", $middleware);
    }


    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {
            $route = $this->routes[$method][$uri];

            if ($route['middleware']) {
                $middleware = new $route['middleware']();
                $middleware->handle();
            }

            $controller = $route['controller'];
            $action = $route['action'];
            $controller = new $controller($this->db);
            $controller->$action();
        } else {
            throw new \Exception("No route found!: $uri. $method");
        }
    }
}
