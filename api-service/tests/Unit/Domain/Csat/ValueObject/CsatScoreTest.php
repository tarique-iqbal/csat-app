<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Csat\ValueObject;

use App\Domain\Csat\Model\CsatResponse;
use App\Domain\Csat\ValueObject\CsatScore;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

final class CsatScoreTest extends TestCase
{
    public function test_calculates_csat_score_correctly(): void
    {
        $responses = new ArrayIterator([
            new CsatResponse(5),
            new CsatResponse(4),
            new CsatResponse(4),
            new CsatResponse(3),
            new CsatResponse(2),
            new CsatResponse(1),
        ]);

        $score = CsatScore::fromResponses($responses);

        self::assertSame(50.0, $score->value());
    }

    public function test_returns_zero_when_no_responses(): void
    {
        $responses = new ArrayIterator([]);

        $score = CsatScore::fromResponses($responses);

        self::assertSame(0.0, $score->value());
    }

    public function test_rounds_the_csat_score_to_two_decimals(): void
    {
        $responses = new ArrayIterator([
            new CsatResponse(5),
            new CsatResponse(4),
            new CsatResponse(2),
        ]);

        $score = CsatScore::fromResponses($responses);

        self::assertSame(66.67, $score->value());
    }
}
