<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Exception;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Exception\ExceptionHandler;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class ExceptionHandlerTest extends TestCase
{
    public function test_report_logs_and_outputs_exception_message(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $exception = new RuntimeException('Something went wrong');

        $logger->expects($this->once())
            ->method('error')
            ->with(
                $this->equalTo('Something went wrong'),
                $this->callback(function ($context) use ($exception) {
                    return isset($context['exception']) && $context['exception'] === $exception;
                })
            );

        $handler = new ExceptionHandler($logger);

        ob_start();
        $handler->report($exception);
        $output = ob_get_clean();

        $this->assertStringContainsString('Unhandled error/exception: Something went wrong', $output);
    }
}
