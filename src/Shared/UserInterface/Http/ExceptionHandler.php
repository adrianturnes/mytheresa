<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Http;

use App\Shared\Domain\Exception\ConflictException;
use App\Shared\Domain\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class ExceptionHandler
{
    public function handle(Throwable $exception): JsonResponse
    {
        $statusCode = $this->statusCode($exception);
        $exceptionData = $this->generateJsonData($exception, $statusCode);

        return new JsonResponse($exceptionData, $statusCode);
    }

    private function statusCode(Throwable $exception): int
    {
        if ($exception instanceof NotFoundException) {
            return JsonResponse::HTTP_NOT_FOUND;
        }

        if ($exception instanceof ConflictException)
        {
            return JsonResponse::HTTP_CONFLICT;
        }

        return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function generateJsonData(Throwable $exception, ?int $statusCode): array
    {
        return [
            'status' => 'error',
            'message' => $exception->getMessage(),
            'code' => $statusCode,
            'data' => [
                'exception' => get_class($exception),
                'trace' => !isEmpty($exception->getTrace()) ? $exception->getTrace() : null,
            ],
        ];
    }
}
