<?php

declare(strict_types=1);

define("BASE_DIR", dirname(__DIR__));

require BASE_DIR . '/vendor/autoload.php';

use App\Infrastructure\Exception\ExceptionHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

require BASE_DIR . '/config/load_env.php';
$container = require BASE_DIR . '/config/container.php';

set_exception_handler([$container->get(ExceptionHandler::class), 'report']);

$routerFactory = require BASE_DIR . '/config/routes.php';
$router = $routerFactory($container);

$psr17Factory = new Psr17Factory();
$request = (new ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
))->fromGlobals();

$response = $router->dispatch($request);
(new SapiEmitter())->emit($response);
