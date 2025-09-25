<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

use App\Domain\Csat\Model\CsatResponse;
use Traversable;

final readonly class CsatScore
{
    private function __construct(private float $value)
    {
    }

    /**
     * @param Traversable<CsatResponse> $responses
     * @return CsatScore
     */
    public static function fromResponses(Traversable $responses): self
    {
        $total = 0;
        $satisfied = 0;

        foreach ($responses as $response) {
            ++$total;
            if ($response->isSatisfied()) {
                ++$satisfied;
            }
        }

        $csat = $total > 0
            ? ($satisfied / $total) * 100
            : 0.0;

        return new self(round($csat, 2));
    }

    public function value(): float
    {
        return $this->value;
    }
}
