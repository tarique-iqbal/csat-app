<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

use App\Domain\Contact\Exception\ContactMessageException;
use App\Infrastructure\Http\JsonResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Log\LoggerInterface;
use Throwable;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\MethodNotAllowedException;

final readonly class ExceptionHandler
{
    /** @var array<string, string> */
    private array $corsHeaders;

    public function __construct(private LoggerInterface $logger)
    {
        $this->corsHeaders = [
            'Access-Control-Allow-Origin' => $_ENV['CORS_ALLOW_ORIGIN'] ?? '*',
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization'
        ];
    }

    public function report(Throwable $exception): void
    {
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);

        if (PHP_SAPI !== 'cli') {
            if ($exception instanceof NotFoundException) {
                $response = new JsonResponse(['error' => 'Route not found'], 404);
            } elseif ($exception instanceof MethodNotAllowedException) {
                $response = new JsonResponse(['error' => 'Method not allowed'], 405);
            } elseif ($exception instanceof ContactMessageException) {
                $response = new JsonResponse(['error' => $exception->getMessage()], 422, $this->corsHeaders);
            } else {
                $response = new JsonResponse(['error' => 'Unexpected error occurred'], 500);
            }

            (new SapiEmitter())->emit($response);
        } else {
            echo 'Unhandled error/exception: ' . $exception->getMessage() . PHP_EOL;
        }
    }
}
