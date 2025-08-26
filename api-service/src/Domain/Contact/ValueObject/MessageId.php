<?php

declare(strict_types=1);

namespace App\Domain\Contact\ValueObject;

use App\Domain\Contact\Exception\ContactMessageException;

final class MessageId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new ContactMessageException('ContactMessageId must be a positive integer.');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(MessageId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
