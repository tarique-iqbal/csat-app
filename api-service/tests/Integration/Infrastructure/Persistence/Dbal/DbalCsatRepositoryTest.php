<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Dbal;

use App\Domain\Csat\Model\CsatResponse;
use App\Domain\Csat\Repository\CsatRepositoryInterface;
use App\Domain\Csat\ValueObject\CsatWeeklyScore;
use App\Domain\Csat\ValueObject\Score;
use App\Domain\Csat\ValueObject\UserId;
use App\Domain\Csat\ValueObject\Week;
use App\Domain\Csat\ValueObject\Year;
use App\Infrastructure\Persistence\Dbal\DbalCsatRepository;
use App\Infrastructure\Persistence\Schema\Tables;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class DbalCsatRepositoryTest extends IntegrationTestCase
{
    private CsatRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new DbalCsatRepository($this->connection);
    }

    public function test_persists_multiple_csat_weekly_scores(): void
    {
        $weeklyScores = [
            new CsatWeeklyScore(new UserId(1), new Score(5), new Week(20), new Year(2024)),
            new CsatWeeklyScore(new UserId(2), new Score(3), new Week(20), new Year(2024)),
        ];

        $this->repository->saveMany($weeklyScores);

        $result = $this->connection->fetchAllAssociative(
            sprintf('SELECT * FROM %s ORDER BY user_id ASC', Tables::CSAT_SCORES)
        );

        self::assertCount(2, $result);
        self::assertSame(1, (int) $result[0]['user_id']);
        self::assertSame(5, (int) $result[0]['score']);
        self::assertSame(20, (int) $result[0]['week']);
        self::assertSame(2024, (int) $result[0]['year']);

        self::assertSame(2, (int) $result[1]['user_id']);
        self::assertSame(3, (int) $result[1]['score']);
    }

    public function test_returns_true_if_feedback_exists(): void
    {
        $feedback = new CsatWeeklyScore(
            new UserId(1),
            new Score(4),
            new Week(20),
            new Year(2024),
        );

        $this->connection->insert(Tables::CSAT_SCORES, [
            'user_id' => $feedback->userId->value(),
            'score' => $feedback->score->value(),
            'week' => $feedback->week->value(),
            'year' => $feedback->year->value(),
        ]);

        $result = $this->repository->hasWeeklyScore($feedback);

        self::assertTrue($result);
    }

    public function test_returns_false_if_feedback_does_not_exist(): void
    {
        $feedback = new CsatWeeklyScore(
            new UserId(99),
            new Score(4),
            new Week(21),
            new Year(2024),
        );

        $result = $this->repository->hasWeeklyScore($feedback);

        self::assertFalse($result);
    }

    public function test_find_all_by_week(): void
    {
        $this->insertSampleScores([
            [1, 5, 20, 2024],
            [2, 3, 20, 2024],
            [3, 4, 20, 2024],
            [4, 4, 20, 2023],
        ]);

        $results = iterator_to_array($this->repository->findAllByWeek(20));

        self::assertCount(4, $results);
        self::assertContainsOnlyInstancesOf(CsatResponse::class, $results);
        self::assertEquals([5, 3, 4, 4], array_map(static fn (CsatResponse $r) => $r->value(), $results));
    }

    public function test_find_all_by_week_and_year(): void
    {
        $this->insertSampleScores([
            [1, 5, 21, 2023],
            [2, 3, 21, 2024],
            [3, 4, 21, 2024],
        ]);

        $results = iterator_to_array($this->repository->findAllByWeekAndYear(21, 2024));

        self::assertCount(2, $results);
        self::assertEquals([3, 4], array_map(static fn (CsatResponse $r) => $r->value(), $results));
    }

    private function insertSampleScores(array $rows): void
    {
        foreach ($rows as [$userId, $score, $week, $year]) {
            $this->connection->insert(Tables::CSAT_SCORES, [
                'user_id' => $userId,
                'score' => $score,
                'week' => $week,
                'year' => $year,
            ]);
        }
    }
}
