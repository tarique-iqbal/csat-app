<?php

declare(strict_types=1);

namespace App\Application\Contact\UseCase;

use App\Domain\Contact\Entity\ContactMessage;
use App\Domain\Contact\Repository\ContactMessageRepositoryInterface;
use App\Domain\Contact\ValueObject\Email;
use App\Domain\Contact\ValueObject\Message;
use App\Domain\Contact\ValueObject\Name;
use DateTimeImmutable;

final readonly class SubmitContactMessageUseCase
{
    public function __construct(private ContactMessageRepositoryInterface $repository)
    {
    }

    public function execute(string $name, string $email, string $message): ContactMessage
    {
        $contactMessage = new ContactMessage(
            name: new Name($name),
            email: new Email($email),
            message: new Message($message),
            submittedAt: new DateTimeImmutable(),
        );

        $this->repository->save($contactMessage);

        return $contactMessage;
    }
}
