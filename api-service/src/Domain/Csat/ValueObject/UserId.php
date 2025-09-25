<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

use InvalidArgumentException;

final readonly class UserId
{
    public function __construct(private int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('User ID must be a positive integer.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
