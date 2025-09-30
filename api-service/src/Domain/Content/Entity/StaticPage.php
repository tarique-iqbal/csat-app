<?php

declare(strict_types=1);

namespace App\Domain\Content\Entity;

use App\Domain\Content\ValueObject\StaticPageId;
use App\Domain\Content\ValueObject\Slug;
use App\Domain\Content\ValueObject\Title;
use App\Domain\Content\ValueObject\Content;
use DateTimeImmutable;
use LogicException;

final class StaticPage
{
    private ?StaticPageId $id;

    public function __construct(
        ?StaticPageId $id,
        private readonly Slug $slug,
        private Title $title,
        private Content $content,
        private readonly DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt = null,
        private bool $published = true,
    ) {
        $this->id = $id;
    }

    public function setId(StaticPageId $id): void
    {
        if ($this->id !== null) {
            throw new LogicException('ID is already set.');
        }
        $this->id = $id;
    }

    public function id(): ?StaticPageId
    {
        return $this->id;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function published(): bool
    {
        return $this->published;
    }

    public function unpublish(): void
    {
        $this->published = false;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function publish(): void
    {
        $this->published = true;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function update(Title $title, Content $content): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->updatedAt = new DateTimeImmutable();
    }
}
