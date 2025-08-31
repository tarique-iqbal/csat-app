<?php

declare(strict_types=1);

namespace App\Domain\Contact\ValueObject;

use App\Domain\Contact\Exception\ContactMessageException;

final class Message
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new ContactMessageException('Message cannot be empty');
        }

        if (mb_strlen($value) < 80) {
            throw new ContactMessageException('Message must be at least 80 characters long');
        }

        if (mb_strlen($value) > 2000) {
            throw new ContactMessageException('Message must not exceed 2000 characters');
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
