<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Nyholm\Psr7\Response;

final class JsonResponse extends Response
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     */
    public function __construct(
        array $data,
        int $status = 200,
        array $headers = []
    ) {
        $headers = array_merge(['Content-Type' => 'application/json'], $headers);

        parent::__construct($status, $headers, json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}
