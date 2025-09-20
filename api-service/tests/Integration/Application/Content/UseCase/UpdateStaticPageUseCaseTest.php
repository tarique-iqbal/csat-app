<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Content\UseCase;

use App\Application\Content\UseCase\CreateStaticPageUseCase;
use App\Application\Content\UseCase\UpdateStaticPageUseCase;
use App\Domain\Content\Exception\StaticPageNotFoundException;
use App\Infrastructure\Persistence\Dbal\DbalStaticPageRepository;
use App\Infrastructure\Persistence\Schema\Tables;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class UpdateStaticPageUseCaseTest extends IntegrationTestCase
{
    private CreateStaticPageUseCase $createUseCase;

    private UpdateStaticPageUseCase $updateUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new DbalStaticPageRepository($this->connection);
        $this->createUseCase = new CreateStaticPageUseCase($repository);
        $this->updateUseCase = new UpdateStaticPageUseCase($repository);
    }

    public function test_it_updates_a_static_page(): void
    {
        $page = $this->createUseCase->execute(
            slug: 'faq',
            title: 'FAQ',
            content: 'Frequently Asked Questions.'
        );
        $id = $page->id();

        $updated = $this->updateUseCase->execute(
            id: $id->value(),
            title: 'Updated FAQ',
            content: 'Updated content goes here.'
        );

        self::assertSame('Updated FAQ', (string) $updated->title());
        self::assertSame('Updated content goes here.', (string) $updated->content());
        self::assertNotNull($updated->updatedAt());

        $row = $this->connection->fetchAssociative(
            sprintf('SELECT * FROM %s WHERE id = ?', Tables::STATIC_PAGES),
            [$id->value()]
        );

        self::assertSame('faq', $row['slug']);
        self::assertSame('Updated FAQ', $row['title']);
        self::assertSame('Updated content goes here.', $row['content']);
        self::assertNotNull($row['updated_at']);
    }

    public function test_it_throws_when_updating_nonexistent_page(): void
    {
        $this->expectException(StaticPageNotFoundException::class);

        $this->updateUseCase->execute(
            id: 999,
            title: 'Ghost Page',
            content: 'This should not exist.'
        );
    }
}
