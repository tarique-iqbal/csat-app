<?php

declare(strict_types=1);

namespace App\Domain\Csat\Repository;

use App\Domain\Csat\Model\CsatResponse;
use App\Domain\Csat\ValueObject\CsatWeeklyScore;
use Traversable;

interface CsatRepositoryInterface
{
    /** @param CsatWeeklyScore[] $weeklyScores */
    public function saveMany(iterable $weeklyScores): void;

    public function hasWeeklyScore(CsatWeeklyScore $score): bool;

    /** @return Traversable<CsatResponse> */
    public function findAllByWeek(int $week): Traversable;

    /** @return Traversable<CsatResponse> */
    public function findAllByWeekAndYear(int $week, int $year): Traversable;
}
