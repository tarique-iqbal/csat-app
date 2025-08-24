<?php

declare(strict_types=1);

namespace App\Domain\Common\Exception;

abstract class DomainException extends \DomainException
{
    abstract public function statusCode(): int;
}
