<?php

declare(strict_types=1);

namespace App\Interface\Http;

use App\Application\Content\UseCase\ListStaticPagesUseCase;
use App\Domain\Content\Entity\StaticPage;
use App\Infrastructure\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class ListStaticPagesController
{
    public function __construct(private ListStaticPagesUseCase $useCase)
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $pages = $this->useCase->execute();

        $data = array_map(fn (StaticPage $page) => [
            'slug' => (string) $page->slug(),
            'title' => (string) $page->title(),
            'content' => (string) $page->content(),
        ], $pages);

        return new JsonResponse($data);
    }
}
