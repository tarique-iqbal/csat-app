<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Dbal;

use App\Domain\Csat\Model\CsatResponse;
use App\Domain\Csat\Repository\CsatRepositoryInterface;
use App\Domain\Csat\ValueObject\CsatWeeklyScore;
use App\Infrastructure\Persistence\Schema\Tables;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Traversable;

final readonly class DbalCsatRepository implements CsatRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @param CsatWeeklyScore[] $weeklyScores
     * @throws Exception
     */
    public function saveMany(iterable $weeklyScores): void
    {
        $sqlPrefix = sprintf('INSERT INTO %s (user_id, score, week, year) VALUES ', Tables::CSAT_SCORES);
        $values = [];
        $params = [];

        foreach ($weeklyScores as $score) {
            $values[] = '(?, ?, ?, ?)';
            $params[] = $score->userId->value();
            $params[] = $score->score->value();
            $params[] = $score->week->value();
            $params[] = $score->year->value();
        }

        $sql = $sqlPrefix . implode(', ', $values);
        $this->connection->executeStatement($sql, $params);
    }

    /** @throws Exception */
    public function hasWeeklyScore(CsatWeeklyScore $score): bool
    {
        $sql = sprintf('SELECT 1
            FROM %s
            WHERE `user_id` = :user_id
              AND `week` = :week
              AND `year` = :year
            LIMIT 1', Tables::CSAT_SCORES);

        $result = $this->connection->fetchOne($sql, [
            'user_id' => $score->userId->value(),
            'week' => $score->week->value(),
            'year' => $score->year->value(),
        ]);

        return $result !== false;
    }

    /** @throws Exception */
    public function findAllByWeek(int $week): Traversable
    {
        return $this->findByWeekYear($week);
    }

    /**
     * @return Traversable<CsatResponse>
     * @throws Exception
     */
    public function findAllByWeekAndYear(int $week, int $year): Traversable
    {
        return $this->findByWeekYear($week, $year);
    }

    /**
     * @return Traversable<CsatResponse>
     * @throws Exception
     */
    private function findByWeekYear(int $week, ?int $year = null): Traversable
    {
        $sql = sprintf('SELECT `score` FROM %s WHERE `week` = :week', Tables::CSAT_SCORES);
        $params = ['week' => $week];

        if ($year !== null) {
            $sql .= ' AND `year` = :year';
            $params['year'] = $year;
        }

        $stmt = $this->connection->executeQuery($sql, $params);

        foreach ($stmt->iterateAssociative() as $row) {
            yield new CsatResponse((int) $row['score']);
        }
    }
}
