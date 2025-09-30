<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Content\UseCase;

use App\Application\Content\UseCase\ListStaticPagesUseCase;
use App\Domain\Content\Entity\StaticPage;
use App\Domain\Content\ValueObject\Content;
use App\Domain\Content\ValueObject\Slug;
use App\Domain\Content\ValueObject\Title;
use App\Infrastructure\Persistence\Dbal\DbalStaticPageRepository;
use DateTimeImmutable;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class ListStaticPagesUseCaseTest extends IntegrationTestCase
{
    private DbalStaticPageRepository $repository;

    private ListStaticPagesUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new DbalStaticPageRepository($this->connection);
        $this->useCase = new ListStaticPagesUseCase($this->repository);
    }

    public function test_it_lists_all_static_pages(): void
    {
        $this->createPage('about-us', 'About Us', 'This is about us.');
        $this->createPage('faq', 'FAQ', 'Frequently asked questions.');

        $pages = $this->useCase->execute();

        self::assertCount(2, $pages);

        $slugs = array_map(fn (StaticPage $p) => (string) $p->slug(), $pages);
        self::assertContains('about-us', $slugs);
        self::assertContains('faq', $slugs);

        $titles = array_map(fn (StaticPage $p) => (string) $p->title(), $pages);
        self::assertContains('About Us', $titles);
        self::assertContains('FAQ', $titles);
    }

    private function createPage(string $slug, string $title, string $content): void
    {
        $page = new StaticPage(
            id: null,
            slug: new Slug($slug),
            title: new Title($title),
            content: new Content($content),
            createdAt: new DateTimeImmutable(),
        );

        $this->repository->save($page);
    }
}
