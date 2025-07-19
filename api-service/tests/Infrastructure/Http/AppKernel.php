<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http;

use DI\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppKernel
{
    private Router $router;

    public function __construct(Container $container)
    {
        $this->router = new Router();
        $this->router->setStrategy(new ApplicationStrategy());
        $this->router->getStrategy()->setContainer($container);

        $this->defineRoutes();
    }

    private function defineRoutes(): void
    {
        foreach (glob(BASE_DIR . '/config/routes/*.php') as $file) {
            $registerRoutes = require $file;
            if (is_callable($registerRoutes)) {
                $registerRoutes($this->router);
            }
        }
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->router->dispatch($request);
    }
}
