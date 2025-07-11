<?php

declare(strict_types=1);

use App\Domain\Csat\Repository\CsatRepositoryInterface;
use App\Infrastructure\Persistence\Dbal\DbalCsatRepository;
use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use function DI\autowire;

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
    CsatRepositoryInterface::class => autowire(DbalCsatRepository::class),
]);

return $builder->build();
