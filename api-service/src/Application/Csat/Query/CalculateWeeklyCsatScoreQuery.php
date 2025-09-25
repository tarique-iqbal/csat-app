<?php

declare(strict_types=1);

namespace App\Application\Csat\Query;

use App\Domain\Csat\ValueObject\WeekOfYear;

final readonly class CalculateWeeklyCsatScoreQuery
{
    public function __construct(public WeekOfYear $weekOfYear)
    {
    }
}
