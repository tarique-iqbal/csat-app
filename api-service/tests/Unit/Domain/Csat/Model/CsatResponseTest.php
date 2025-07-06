<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Csat\Model;

use App\Domain\Csat\Model\CsatResponse;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CsatResponseTest extends TestCase
{
    public function test_returns_the_score_value(): void
    {
        $response = new CsatResponse(5);
        self::assertSame(5, $response->value());
    }

    public function test_satisfied_when_score_is_4_or_5(): void
    {
        self::assertTrue((new CsatResponse(4))->isSatisfied());
        self::assertTrue((new CsatResponse(5))->isSatisfied());
        self::assertFalse((new CsatResponse(3))->isSatisfied());
    }

    public function test_dissatisfied_when_score_is_2_or_below(): void
    {
        self::assertTrue((new CsatResponse(1))->isDissatisfied());
        self::assertTrue((new CsatResponse(1))->isDissatisfied());
        self::assertFalse((new CsatResponse(4))->isDissatisfied());
    }

    public function test_neutral_when_score_is_7_or_8(): void
    {
        self::assertTrue((new CsatResponse(3))->isNeutral());
        self::assertFalse((new CsatResponse(4))->isNeutral());
    }

    public function test_throws_exception_for_invalid_score(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CsatResponse(-1);
    }

    public function test_throws_exception_for_score_above_5(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CsatResponse(7);
    }
}
