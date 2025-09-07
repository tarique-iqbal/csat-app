<?php

declare(strict_types=1);

namespace App\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;

final class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new ContentException('Title cannot be empty');
        }

        if (strlen($value) < 3) {
            throw new ContentException('Title must be at least 3 characters.');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
