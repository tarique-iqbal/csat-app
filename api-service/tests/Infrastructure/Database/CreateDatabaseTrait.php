<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Database;

use Doctrine\DBAL\Connection;

trait CreateDatabaseTrait
{
    protected function createSchema(Connection $connection): void
    {
        $connection->executeStatement(<<<SQL
            CREATE TABLE IF NOT EXISTS csat_scores (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED NOT NULL,
                score SMALLINT UNSIGNED NOT NULL,
                week SMALLINT UNSIGNED NOT NULL,
                year SMALLINT UNSIGNED NOT NULL,
                UNIQUE KEY unique_user_week_year (user_id, week, year)
            )
            SQL);
    }

    protected function truncateTable(Connection $connection): void
    {
        $connection->executeStatement('TRUNCATE TABLE csat_scores');
    }
}
