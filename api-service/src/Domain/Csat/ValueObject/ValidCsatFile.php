<?php

declare(strict_types=1);

namespace App\Domain\Csat\ValueObject;

use InvalidArgumentException;

final readonly class ValidCsatFile
{
    private Week $week;

    private Year $year;

    public function __construct(private string $filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new InvalidArgumentException("File: {$filePath} does not exist or is not readable.");
        }

        $fileName = basename($filePath);

        if (!preg_match('/^csat_week_(\d{4})_(\d{1,2})\.csv$/', $fileName, $matches)) {
            throw new InvalidArgumentException('Expected filename format: csat_week_{year}_{week}.csv');
        }

        [, $year, $week] = $matches;

        $this->week = new Week((int) $week);
        $this->year = new Year((int) $year);
    }

    public function filePath(): string
    {
        return $this->filePath;
    }

    public function week(): Week
    {
        return $this->week;
    }

    public function year(): Year
    {
        return $this->year;
    }
}
