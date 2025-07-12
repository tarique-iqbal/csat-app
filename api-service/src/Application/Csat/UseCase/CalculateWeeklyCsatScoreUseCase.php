<?php

declare(strict_types=1);

namespace App\Application\Csat\UseCase;

use App\Application\Csat\Query\CalculateWeeklyCsatScoreQuery;
use App\Domain\Csat\Repository\CsatRepositoryInterface;
use App\Domain\Csat\ValueObject\CsatScore;

final readonly class CalculateWeeklyCsatScoreUseCase
{
    public function __construct(
        private CsatRepositoryInterface $csatRepository,
    ) {
    }

    public function execute(CalculateWeeklyCsatScoreQuery $query): float
    {
        $week = $query->weekOfYear->week();
        $year = $query->weekOfYear->year();

        $responses = $year === null
            ? $this->csatRepository->findAllByWeek($week)
            : $this->csatRepository->findAllByWeekAndYear($week, $year);

        return CsatScore::fromResponses($responses)->value();
    }
}
