<?php

declare(strict_types=1);

namespace App\Application\Content\UseCase;

use App\Domain\Content\Entity\StaticPage;
use App\Domain\Content\Repository\StaticPageRepositoryInterface;
use App\Domain\Content\ValueObject\Content;
use App\Domain\Content\ValueObject\StaticPageId;
use App\Domain\Content\ValueObject\Title;

final readonly class UpdateStaticPageUseCase
{
    public function __construct(private StaticPageRepositoryInterface $repository)
    {
    }

    public function execute(int $id, string $title, string $content): StaticPage
    {
        $page = $this->repository->findById(new StaticPageId($id));

        $page->update(new Title($title), new Content($content));

        $this->repository->save($page);

        return $page;
    }
}
