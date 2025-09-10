<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;
use App\Domain\Content\ValueObject\Slug;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SlugTest extends TestCase
{
    public static function valid_slug_provider(): array
    {
        return [
            ['hello'],
            ['hello-world'],
            ['about-us'],
            ['asd-ytr-dke'],
            ['simplepage'],
        ];
    }

    #[DataProvider('valid_slug_provider')]
    public function test_it_accepts_valid_slugs(string $slug): void
    {
        $obj = new Slug($slug);
        self::assertSame($slug, $obj->value());
        self::assertSame($slug, (string)$obj);
    }

    public static function invalid_slug_provider(): array
    {
        return [
            ['-hello'],
            ['hello-'],
            ['hello--world'],
            ['hello_world'],
            ['HelloWorld'],
            ['123start'],
            ['hello123'],
            [''],
            ['   '],
        ];
    }

    #[DataProvider('invalid_slug_provider')]
    public function test_it_rejects_invalid_slugs(string $slug): void
    {
        $this->expectException(ContentException::class);
        new Slug($slug);
    }
}
