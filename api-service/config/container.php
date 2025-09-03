<?php

declare(strict_types=1);

use App\Application\Contact\UseCase\SubmitContactMessageUseCase;
use App\Application\Csat\UseCase\CalculateWeeklyCsatScoreUseCase;
use App\Domain\Contact\Repository\ContactMessageRepositoryInterface;
use App\Domain\Csat\Repository\CsatRepositoryInterface;
use App\Infrastructure\Persistence\Dbal\DbalContactMessageRepository;
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
    CalculateWeeklyCsatScoreUseCase::class => autowire(),
    ContactMessageRepositoryInterface::class => autowire(DbalContactMessageRepository::class),
    SubmitContactMessageUseCase::class => autowire(),
]);

return $builder->build();
