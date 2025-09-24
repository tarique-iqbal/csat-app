<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Content\UseCase;

use App\Application\Content\UseCase\CreateStaticPageUseCase;
use App\Application\Content\UseCase\GetStaticPageBySlugUseCase;
use App\Domain\Content\Entity\StaticPage;
use App\Domain\Content\Exception\StaticPageNotFoundException;
use App\Infrastructure\Persistence\Dbal\DbalStaticPageRepository;
use Tests\Infrastructure\Database\IntegrationTestCase;

final class GetStaticPageBySlugUseCaseTest extends IntegrationTestCase
{
    private CreateStaticPageUseCase $createUseCase;

    private GetStaticPageBySlugUseCase $getUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = new DbalStaticPageRepository($this->connection);
        $this->createUseCase = new CreateStaticPageUseCase($repository);
        $this->getUseCase = new GetStaticPageBySlugUseCase($repository);
    }

    public function test_it_returns_static_page_when_found(): void
    {
        $this->createUseCase->execute(
            slug: 'about-us',
            title: 'About Us',
            content: 'This is about us page.'
        );

        $staticPage = $this->getUseCase->execute('about-us');

        self::assertInstanceOf(StaticPage::class, $staticPage);
        self::assertSame('about-us', (string) $staticPage->slug());
        self::assertSame('About Us', (string) $staticPage->title());
    }

    public function test_it_throws_exception_when_not_found(): void
    {
        $this->expectException(StaticPageNotFoundException::class);

        $this->getUseCase->execute('non-existent-page');
    }
}
