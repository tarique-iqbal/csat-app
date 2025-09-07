<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;
use App\Domain\Content\ValueObject\Title;
use PHPUnit\Framework\TestCase;

final class TitleTest extends TestCase
{
    public function test_it_accepts_valid_title(): void
    {
        $title = new Title('About Us');
        self::assertSame('About Us', $title->value());
        self::assertSame('About Us', (string)$title);
    }

    public function test_it_trims_whitespace(): void
    {
        $title = new Title('   Hello World   ');
        self::assertSame('Hello World', $title->value());
    }

    public function test_it_rejects_empty_string(): void
    {
        $this->expectException(ContentException::class);
        new Title('');
    }

    public function test_it_rejects_too_short_title(): void
    {
        $this->expectException(ContentException::class);
        new Title('Hi');
    }
}
