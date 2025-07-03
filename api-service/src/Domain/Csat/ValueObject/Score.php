<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

use InvalidArgumentException;

final readonly class Score
{
    public function __construct(
        private int $value,
    ) {
        if ($value < 1 || $value > 5) {
            throw new InvalidArgumentException('Score must be between 1 and 5.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
