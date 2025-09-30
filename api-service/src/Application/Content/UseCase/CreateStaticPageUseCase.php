<?php

declare(strict_types=1);

namespace App\Application\Content\UseCase;

use App\Domain\Content\Entity\StaticPage;
use App\Domain\Content\Repository\StaticPageRepositoryInterface;
use App\Domain\Content\ValueObject\Content;
use App\Domain\Content\ValueObject\Slug;
use App\Domain\Content\ValueObject\Title;
use DateTimeImmutable;

final readonly class CreateStaticPageUseCase
{
    public function __construct(private StaticPageRepositoryInterface $repository)
    {
    }

    public function execute(string $slug, string $title, string $content): StaticPage
    {
        $page = new StaticPage(
            id: null,
            slug: new Slug($slug),
            title: new Title($title),
            content: new Content($content),
            createdAt: new DateTimeImmutable(),
            updatedAt: null,
        );

        $this->repository->save($page);

        return $page;
    }
}
