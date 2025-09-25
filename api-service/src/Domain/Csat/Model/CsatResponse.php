<?php

declare(strict_types=1);

namespace App\Domain\Csat\Model;

use InvalidArgumentException;

final readonly class CsatResponse
{
    public function __construct(private int $score)
    {
        if ($score < 1 || $score > 5) {
            throw new InvalidArgumentException('Score must be between 1 and 5.');
        }
    }

    public function isSatisfied(): bool
    {
        return $this->score >= 4;
    }

    public function isDissatisfied(): bool
    {
        return $this->score <= 2;
    }

    public function isNeutral(): bool
    {
        return $this->score === 3;
    }

    public function value(): int
    {
        return $this->score;
    }
}
