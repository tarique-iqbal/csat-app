<?php

declare(strict_types=1);

namespace App\Domain\Content\Exception;

use RuntimeException;

final class StaticPageNotFoundException extends RuntimeException
{
    public static function forId(int $id): self
    {
        return new self(sprintf('StaticPage not found for id %d', $id));
    }

    public static function forSlug(string $slug): self
    {
        return new self(sprintf('StaticPage not found for slug "%s"', $slug));
    }
}
