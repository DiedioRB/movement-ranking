<?php

use App\Routes\Router;
use App\Core\Log;
use App\Core\Response;

// Composer autoload
require __DIR__.'/../vendor/autoload.php';

// Loads the .ENV variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

set_exception_handler(function ($e) {
    Log::error($e->getMessage(), [
        'trace' => $e->getTraceAsString()
    ]);

    echo Response::json([], 500);
});

// Enables routing
$router = require "routes/paths.php";

// Recover the current URI without parameters and method used
$uri = strtok($_SERVER['REQUEST_URI'], "?");
$method = $_SERVER['REQUEST_METHOD'];

// Tries to find the requested URL within the router paths and executes its function
Log::info("Endpoint accessed", ["URI" => $uri, "Method" => $method]);
$router->find($uri, $method);