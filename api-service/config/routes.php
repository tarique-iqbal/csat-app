<?php

declare(strict_types=1);

use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container): Router {
    $router = new Router();
    $strategy = new ApplicationStrategy();
    $strategy->setContainer($container);
    $router->setStrategy($strategy);

    $router->group('/api', function (RouteGroup $route) {
    });

    return $router;
};
