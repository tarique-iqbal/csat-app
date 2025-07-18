<?php

declare(strict_types=1);

use App\Interface\Http\CalculateCsatController;
use League\Route\Router;
use League\Route\RouteGroup;

return function (Router $router): void {
    $router->group('/api', function (RouteGroup $route) {
        $route->map('GET', '/csat/{year:number}/{week:number}', CalculateCsatController::class);
        $route->map('GET', '/csat/{week:number}', CalculateCsatController::class);
    });
};
