<?php

declare(strict_types=1);

namespace App\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;

final class StaticPageId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new ContentException('StaticPageId must be positive.');
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
