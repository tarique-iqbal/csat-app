<?php

declare(strict_types=1);

use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container): Router {
    $router = new Router();
    $strategy = new ApplicationStrategy();
    $strategy->setContainer($container);
    $router->setStrategy($strategy);

    foreach (glob(BASE_DIR . '/config/routes/*.php') as $file) {
        $registerRoutes = require $file;
        if (is_callable($registerRoutes)) {
            $registerRoutes($router);
        }
    }

    return $router;
};
