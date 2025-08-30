<?php

declare(strict_types=1);

use App\Interface\Http\SubmitContactController;
use League\Route\RouteGroup;
use League\Route\Router;

return function (Router $router): void {
    $router->group('/api', function (RouteGroup $route) {
        $route->map('POST', '/contact', SubmitContactController::class);
    });
};
