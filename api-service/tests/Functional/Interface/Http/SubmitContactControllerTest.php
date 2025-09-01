<?php

declare(strict_types=1);

namespace Tests\Functional\Interface\Http;

use App\Infrastructure\Persistence\Schema\Tables;
use Tests\Infrastructure\Database\FunctionalTestCase;

final class SubmitContactControllerTest extends FunctionalTestCase
{
    public function test_submit_contact_message_returns_201_and_persists_message(): void
    {
        $request = $this->psrFactory->createServerRequest('POST', '/api/contact')
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->psrFactory->createStream(json_encode([
                'name' => 'Alice Eve',
                'email' => 'alice@example.com',
                'message' => 'The quick brown fox jumps over the lazy dog near the riverbank under a cloudy sky.',
            ], JSON_THROW_ON_ERROR)));

        $response = $this->kernel->handle($request);

        self::assertSame(201, $response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        self::assertSame(1, $data['id']);

        $row = $this->connection->fetchAssociative(
            sprintf('SELECT * FROM %s WHERE email = ?', Tables::CONTACT_MESSAGES),
            ['alice@example.com']
        );

        self::assertNotFalse($row);
        self::assertSame('Alice Eve', $row['name']);
        self::assertSame('The quick brown fox jumps over the lazy dog near the riverbank under a cloudy sky.', $row['message']);
    }
}
