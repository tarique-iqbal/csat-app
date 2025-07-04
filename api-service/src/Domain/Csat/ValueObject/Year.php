<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

final readonly class Year
{
    public function __construct(
        private int $value,
    ) {
        $currentYear = (int) (new DateTimeImmutable())->format('Y');
        if ($value < 2000 || $value > $currentYear) {
            throw new InvalidArgumentException("Year must be between 2000 and $currentYear.");
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
