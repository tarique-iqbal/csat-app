<?php

declare(strict_types=1);

namespace Tests\Functional\Interface\Http;

use App\Application\Content\UseCase\CreateStaticPageUseCase;
use App\Infrastructure\Http\JsonResponse;
use App\Infrastructure\Persistence\Dbal\DbalStaticPageRepository;
use Tests\Infrastructure\Database\FunctionalTestCase;

final class ListStaticPagesControllerTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $repository = new DbalStaticPageRepository($this->connection);
        $createUseCase = new CreateStaticPageUseCase($repository);

        $createUseCase->execute(
            slug: 'about-us',
            title: 'About Us',
            content: 'This is the About Us page.',
        );

        $createUseCase->execute(
            slug: 'faq',
            title: 'FAQ',
            content: 'This is the FAQ page.',
        );
    }

    public function test_it_returns_list_of_static_pages_as_json(): void
    {
        $request = $this->psrFactory->createServerRequest('GET', '/api/static-pages');
        $response = $this->kernel->handle($request);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertCount(2, $data);

        self::assertSame('about-us', $data[0]['slug']);
        self::assertSame('About Us', $data[0]['title']);
        self::assertSame('faq', $data[1]['slug']);
        self::assertSame('FAQ', $data[1]['title']);
    }
}
