<?php

declare(strict_types=1);

namespace App\Domain\Contact\Entity;

use App\Domain\Contact\ValueObject\Message;
use App\Domain\Contact\ValueObject\MessageId;
use App\Domain\Contact\ValueObject\Email;
use App\Domain\Contact\ValueObject\Name;
use DateTimeImmutable;
use LogicException;

final class ContactMessage
{
    private ?MessageId $id;

    public function __construct(
        private readonly Name $name,
        private readonly Email $email,
        private readonly Message $message,
        private readonly DateTimeImmutable $submittedAt,
    ) {
        $this->id = null;
    }

    public function setId(MessageId $id): void
    {
        if ($this->id !== null) {
            throw new LogicException('ID is already set.');
        }
        $this->id = $id;
    }

    public function id(): ?MessageId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function message(): Message
    {
        return $this->message;
    }

    public function submittedAt(): DateTimeImmutable
    {
        return $this->submittedAt;
    }
}
