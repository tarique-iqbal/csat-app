<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Contact\UseCase;

use App\Application\Contact\UseCase\SubmitContactMessageUseCase;
use App\Infrastructure\Persistence\Dbal\DbalContactMessageRepository;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class SubmitContactMessageUseCaseTest extends IntegrationTestCase
{
    private SubmitContactMessageUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new DbalContactMessageRepository($this->connection);
        $this->useCase = new SubmitContactMessageUseCase($repository);
    }

    public function test_it_persists_contact_message_in_database(): void
    {
        $contactMessage = $this->useCase->execute(
            'Alice Eve',
            'alice@example.com',
            'The quick brown fox jumps over the lazy dog near the riverbank under a cloudy windy autumn evening sky.'
        );

        self::assertSame('Alice Eve', $contactMessage->name()->value());
        self::assertSame('alice@example.com', $contactMessage->email()->value());
        self::assertSame('The quick brown fox jumps over the lazy dog near the riverbank under a cloudy windy autumn evening sky.', $contactMessage->message()->value());

        $row = $this->connection->fetchAssociative('SELECT * FROM contact_messages WHERE id = ?', [
            $contactMessage->id()->value(),
        ]);

        self::assertNotFalse($row);
        self::assertSame('Alice Eve', $row['name']);
        self::assertSame('alice@example.com', $row['email']);
        self::assertSame('The quick brown fox jumps over the lazy dog near the riverbank under a cloudy windy autumn evening sky.', $row['message']);
    }
}
