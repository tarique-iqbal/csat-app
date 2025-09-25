<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

final readonly class CsatWeeklyScore
{
    public function __construct(
        public UserId $userId,
        public Score $score,
        public Week $week,
        public Year $year
    ) {
    }
}
