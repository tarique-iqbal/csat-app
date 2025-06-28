<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;

return DriverManager::getConnection([
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
]);
