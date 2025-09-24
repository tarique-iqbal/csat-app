<?php

declare(strict_types=1);

namespace App\Application\Content\UseCase;

use App\Domain\Content\Entity\StaticPage;
use App\Domain\Content\Repository\StaticPageRepositoryInterface;
use App\Domain\Content\ValueObject\Slug;

final readonly class GetStaticPageBySlugUseCase
{
    public function __construct(private StaticPageRepositoryInterface $repository)
    {
    }

    public function execute(string $slug): StaticPage
    {
        $slugVo = new Slug($slug);

        return $this->repository->findBySlug($slugVo);
    }
}
