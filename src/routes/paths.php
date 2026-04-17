<?php

use App\Routes\Router;
use App\Controllers\v1\MovementController;

$router = new Router();

// You can create routes here

// Swagger routes
$router->get("/", function (){
    require __DIR__.'/../swagger.php';
});
// Makes the JSON available
$router->get("/openapi.json", function (){
    require __DIR__.'/../../public/openapi.json';
});

// Endpoints
$router->get("/v1/movements/{id}", [MovementController::class, "getRanking"]);

return $router;