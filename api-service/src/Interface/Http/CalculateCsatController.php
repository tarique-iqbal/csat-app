<?php

declare(strict_types=1);

namespace App\Interface\Http;

use App\Application\Csat\Query\CalculateWeeklyCsatScoreQuery;
use App\Application\Csat\UseCase\CalculateWeeklyCsatScoreUseCase;
use App\Domain\Csat\ValueObject\WeekOfYear;
use App\Infrastructure\Http\JsonResponse;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class CalculateCsatController
{
    public function __construct(private CalculateWeeklyCsatScoreUseCase $calculateScoreUseCase)
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $week = (int) $request->getAttribute('week');
        $year = (int) $request->getAttribute('year');
        $year = $year ?: null;

        try {
            $weekOfYear = new WeekOfYear($week, $year);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        $score = $this->calculateScoreUseCase->execute(new CalculateWeeklyCsatScoreQuery($weekOfYear));

        return new JsonResponse([
            'week' => $weekOfYear->week(),
            'year' => $weekOfYear->year(),
            'csat_score' => round($score, 2),
        ]);
    }
}
