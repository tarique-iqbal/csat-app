<?php

declare(strict_types=1);

namespace App\Application\Csat\UseCase;

use App\Domain\Csat\Repository\CsatRepositoryInterface;
use App\Infrastructure\Csv\CsatCsvParser;
use SplFileObject;
use function count;

final readonly class ImportCsatResponsesUseCase
{
    private const BATCH_SIZE = 500;

    public function __construct(
        private CsatRepositoryInterface $repository,
        private CsatCsvParser           $parser,
    ) {
    }

    public function importFromFile(SplFileObject $file, int $week, int $year): void
    {
        $weeklyScores = $userIds = [];

        foreach ($this->parser->parse($file, $week, $year) as $score) {
            if ($this->repository->hasWeeklyScore($score) ||
                in_array($score->userId->value(), $userIds)) {
                continue;
            }

            $weeklyScores[] = $score;
            $userIds[] = $score->userId->value();

            if (count($weeklyScores) === self::BATCH_SIZE) {
                $this->repository->saveMany($weeklyScores);
                $weeklyScores = $userIds = [];
            }
        }

        if (count($weeklyScores) > 0) {
            $this->repository->saveMany($weeklyScores);
        }
    }
}
