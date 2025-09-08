<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;
use App\Domain\Content\ValueObject\Content;
use PHPUnit\Framework\TestCase;

final class ContentTest extends TestCase
{
    public function test_it_accepts_valid_content(): void
    {
        $content = new Content('This is a static page content.');
        self::assertSame('This is a static page content.', $content->value());
        self::assertSame('This is a static page content.', (string)$content);
    }

    public function test_it_trims_whitespace(): void
    {
        $content = new Content("   Some text with spaces   ");
        self::assertSame('Some text with spaces', $content->value());
    }

    public function test_it_rejects_empty_string(): void
    {
        $this->expectException(ContentException::class);
        new Content('');
    }

    public function test_it_rejects_string_with_only_spaces(): void
    {
        $this->expectException(ContentException::class);
        new Content('     ');
    }

    public function test_it_allows_long_text(): void
    {
        $longText = str_repeat('abc ', 1000);
        $content = new Content($longText);
        self::assertSame(trim($longText), $content->value());
    }
}
