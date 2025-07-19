<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Database;

use DI\Container;
use Doctrine\DBAL\Connection;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Tests\Infrastructure\Http\AppKernel;

abstract class FunctionalTestCase extends TestCase
{
    use CreateDatabaseTrait;

    private static bool $initialized = false;

    protected readonly Container $container;

    protected readonly Connection $connection;

    protected readonly Psr17Factory $psrFactory;

    protected readonly AppKernel $kernel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->initializeDependencies();

        if (!self::$initialized) {
            $this->oneTimeSetup();
            self::$initialized = true;
        }

        $this->truncateTable($this->connection);
    }

    private function initializeDependencies(): void
    {
        require BASE_DIR . '/config/load_env.php';
        $this->container = require BASE_DIR . '/config/container.php';
        $this->connection = $this->container->get(Connection::class);
        $this->psrFactory = new Psr17Factory();
        $this->kernel = new AppKernel($this->container);
    }

    private function oneTimeSetup(): void
    {
        $this->createSchema($this->connection);
    }
}
