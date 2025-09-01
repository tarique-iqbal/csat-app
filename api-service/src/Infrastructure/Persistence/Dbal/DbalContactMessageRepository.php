<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Dbal;

use App\Domain\Contact\Entity\ContactMessage;
use App\Domain\Contact\Repository\ContactMessageRepositoryInterface;
use App\Domain\Contact\ValueObject\MessageId;
use App\Infrastructure\Persistence\Schema\Tables;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class DbalContactMessageRepository implements ContactMessageRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    /** @throws Exception */
    public function save(ContactMessage $message): void
    {
        $this->connection->insert(Tables::CONTACT_MESSAGES, [
            'name' => $message->name()->value(),
            'email' => $message->email()->value(),
            'message' => $message->message()->value(),
            'submitted_at' => $message->submittedAt()->format('Y-m-d H:i:s'),
        ]);

        $id = (int) $this->connection->lastInsertId();
        $message->setId(new MessageId($id));
    }
}
