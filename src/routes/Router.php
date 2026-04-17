<?php

namespace App\Routes;

use App\Core\Response;
use App\Core\Log;

class Router
{
    private array $routes = [];

    // Basic function to enable a route
    public function addRoute(string $method, string $path, callable $handler)
    {
        $this->routes[] = [
            "method" => $method,
            "path" => $path,
            "handler" => $handler,
        ];
    }

    // Helper functions to writing routes easier (GET, POST, PUT, PATCH and DELETE)
    public function get(string $path, callable $handler)
    {
        $this->addRoute("GET", $path, $handler);
    }

    public function post()
    {
        $this->addRoute("POST", $path, $handler);
    }

    public function put()
    {
        $this->addRoute("PUT", $path, $handler);
    }
    
    public function patch()
    {
        $this->addRoute("PATCH", $path, $handler);
    }

    public function delete()
    {
        $this->addRoute("DELETE", $path, $handler);
    }

    // Searches for a route in the array and executes the linked function
    public function find(string $uri, string $method)
    {
        foreach($this->routes as $route)
        {
            $pattern = preg_replace("#\{id\}#", "([^/]+)", $route['path']);

            if(
                $method == $route['method'] && //Checks if the route exists
                preg_match("#^$pattern$#", $uri, $id) // Checks if the path variables match the expected for the route
            ){
                // Passes the variable to the function related to the route
                array_shift($id);
                $response = $route['handler'](...$id);

                Log::info("Response returned", ["response" => $response]);
                echo $response;
                return;
            }
        }

        // Fallback to 404 error if no route is found
        echo Response::notFound();
    }
}