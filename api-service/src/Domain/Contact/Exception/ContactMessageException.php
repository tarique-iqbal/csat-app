<?php

declare(strict_types=1);

namespace App\Domain\Contact\Exception;

use App\Domain\Common\Exception\DomainException;

final class ContactMessageException extends DomainException
{
    public function __construct(string $message, private readonly int $statusCode = 422)
    {
        parent::__construct($message);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}
