<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Content\ValueObject;

use App\Domain\Content\Exception\ContentException;
use App\Domain\Content\ValueObject\StaticPageId;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class StaticPageIdTest extends TestCase
{
    public static function validIdProvider(): array
    {
        return [
            [1],
            [10],
            [999],
            [PHP_INT_MAX],
        ];
    }

    #[DataProvider('validIdProvider')]
    public function test_it_accepts_valid_ids(int $id): void
    {
        $obj = new StaticPageId($id);

        self::assertSame($id, $obj->value());
        self::assertSame((string) $id, (string) $obj);
    }

    public static function invalidIdProvider(): array
    {
        return [
            [0],
            [-1],
            [-100],
        ];
    }

    #[DataProvider('invalidIdProvider')]
    public function test_it_rejects_invalid_ids(int $id): void
    {
        $this->expectException(ContentException::class);
        new StaticPageId($id);
    }
}
