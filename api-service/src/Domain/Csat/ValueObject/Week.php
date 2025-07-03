<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

use InvalidArgumentException;

final readonly class Week
{
    public function __construct(
        private int $value,
    ) {
        if ($value < 1 || $value > 53) {
            throw new InvalidArgumentException('Week number must be between 1 and 53.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
