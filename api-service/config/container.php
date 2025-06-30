<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

$builder = new ContainerBuilder();

$builder->addDefinitions([
    Connection::class => function () {
        return require BASE_DIR . '/config/dbal.php';
    },
    LoggerInterface::class => function () {
        $logger = new Logger('csat');
        $logger->pushHandler(new StreamHandler(BASE_DIR . '/var/log/error.log', Level::Debug));
        return $logger;
    },
]);

return $builder->build();
