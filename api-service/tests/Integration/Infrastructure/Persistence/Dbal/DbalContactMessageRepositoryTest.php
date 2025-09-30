<?php

declare(strict_types=1);

namespace Integration\Infrastructure\Persistence\Dbal;

use App\Domain\Contact\Entity\ContactMessage;
use App\Domain\Contact\Repository\ContactMessageRepositoryInterface;
use App\Domain\Contact\ValueObject\Email;
use App\Domain\Contact\ValueObject\Message;
use App\Domain\Contact\ValueObject\Name;
use App\Infrastructure\Persistence\Dbal\DbalContactMessageRepository;
use App\Infrastructure\Persistence\Schema\Tables;
use DateTimeImmutable;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class DbalContactMessageRepositoryTest extends IntegrationTestCase
{
    private ContactMessageRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new DbalContactMessageRepository($this->connection);
    }

    public function test_it_saves_a_contact_message(): void
    {
        $message = new ContactMessage(
            new Name('Alice'),
            new Email('alice@example.com'),
            new Message('The quick brown fox jumps over the lazy dog near the riverbank under a cloudy sky.'),
            new DateTimeImmutable('2025-08-27 10:00:00'),
        );

        $this->repository->save($message);

        $this->assertNotNull($message->id());
        $this->assertSame(1, $message->id()->value());

        $row = $this->connection->fetchAssociative(
            sprintf('SELECT * FROM %s WHERE id = ?', Tables::CONTACT_MESSAGES),
            [$message->id()->value()]
        );

        $this->assertSame('Alice', $row['name']);
        $this->assertSame('alice@example.com', $row['email']);
        $this->assertSame('The quick brown fox jumps over the lazy dog near the riverbank under a cloudy sky.', $row['message']);
        $this->assertSame('2025-08-27 10:00:00', $row['submitted_at']);
    }
}
