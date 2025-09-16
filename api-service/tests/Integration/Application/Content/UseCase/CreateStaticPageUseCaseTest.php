<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Content\UseCase;

use App\Application\Content\UseCase\CreateStaticPageUseCase;
use App\Infrastructure\Persistence\Dbal\DbalStaticPageRepository;
use App\Infrastructure\Persistence\Schema\Tables;
use DateTimeImmutable;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class CreateStaticPageUseCaseTest extends IntegrationTestCase
{
    private CreateStaticPageUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new DbalStaticPageRepository($this->connection);
        $this->useCase = new CreateStaticPageUseCase($repository);
    }

    public function test_it_creates_and_persists_a_static_page(): void
    {
        $page = $this->useCase->execute(
            slug: 'about-us',
            title: 'About Us',
            content: 'This is the About Us page.'
        );

        self::assertNotNull($page->id());
        self::assertSame('about-us', (string) $page->slug());
        self::assertSame('About Us', (string) $page->title());
        self::assertSame('This is the About Us page.', (string) $page->content());
        self::assertInstanceOf(DateTimeImmutable::class, $page->createdAt());
        self::assertNull($page->updatedAt());

        $row = $this->connection->fetchAssociative(
            sprintf('SELECT * FROM %s WHERE id = ?', Tables::STATIC_PAGES),
            [$page->id()->value()]
        );

        self::assertSame('about-us', $row['slug']);
        self::assertSame('About Us', $row['title']);
        self::assertSame('This is the About Us page.', $row['content']);
    }
}
