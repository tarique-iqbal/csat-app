<?php

declare(strict_types=1);

namespace App\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;

final class Slug
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new ContentException('Slug cannot be empty');
        }

        if (strlen($value) < 3) {
            throw new ContentException('Slug must be at least 3 characters.');
        }

        if (!preg_match('/^[a-z]+(?:-[a-z]+)*$/', $value)) {
            throw new ContentException(
                'Slug must contain only lowercase letters and single hyphens, start/end with a letter.'
            );
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
