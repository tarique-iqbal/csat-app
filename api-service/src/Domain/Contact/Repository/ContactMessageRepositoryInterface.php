<?php

declare(strict_types=1);

namespace App\Domain\Contact\Repository;

use App\Domain\Contact\Entity\ContactMessage;

interface ContactMessageRepositoryInterface
{
    public function save(ContactMessage $message): void;
}
