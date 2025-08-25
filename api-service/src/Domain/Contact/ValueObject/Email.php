<?php

declare(strict_types=1);

namespace App\Domain\Contact\ValueObject;

use App\Domain\Contact\Exception\ContactMessageException;

final readonly class Email
{
    private string $value;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ContactMessageException('Invalid email');
        }
        $this->value = strtolower($email);
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
