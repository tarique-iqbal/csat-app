<?php

declare(strict_types=1);

namespace App\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;

final class Content
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new ContentException('Content cannot be empty.');
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
