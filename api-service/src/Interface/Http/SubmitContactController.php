<?php

declare(strict_types=1);

namespace App\Interface\Http;

use App\Application\Contact\UseCase\SubmitContactMessageUseCase;
use App\Infrastructure\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class SubmitContactController
{
    public function __construct(private SubmitContactMessageUseCase $useCase)
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $data = json_decode((string) $request->getBody(), true);

        $contactMessage = $this->useCase->execute(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['message'] ?? '',
        );

        return new JsonResponse(
            ['id' => $contactMessage->id()?->value()],
            201,
        );
    }
}
