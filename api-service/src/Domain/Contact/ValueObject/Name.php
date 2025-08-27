<?php

declare(strict_types=1);

namespace App\Domain\Contact\ValueObject;

use App\Domain\Contact\Exception\ContactMessageException;

final class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new ContactMessageException('Name cannot be empty');
        }

        if (mb_strlen($value) < 2) {
            throw new ContactMessageException('Name must be at least 2 characters long');
        }

        if (mb_strlen($value) > 100) {
            throw new ContactMessageException('Name must not exceed 100 characters');
        }

        if (preg_match('/[0-9\^<,@\/\{\}\(\)\[\]\!\&\\\\`\~\*\$%\?=>:\|;#\x22]/', $value)) {
            throw new ContactMessageException('Special characters and numbers are not allowed in the name');
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
