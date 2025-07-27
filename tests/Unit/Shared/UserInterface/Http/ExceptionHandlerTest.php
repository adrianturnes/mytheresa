<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\UserInterface\Http;

use App\Shared\Domain\Exception\ConflictException;
use App\Shared\Domain\Exception\NotFoundException;
use App\Shared\UserInterface\Http\ExceptionHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionHandlerTest extends TestCase
{
    public function testHandleNotFoundException()
    {
        $handler = new ExceptionHandler();
        $exception = new NotFoundException('No encontrado');

        $response = $handler->handle($exception);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('error', $data['status']);
        $this->assertEquals('No encontrado', $data['message']);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $data['code']);
        $this->assertEquals(NotFoundException::class, $data['data']['exception']);
    }

    public function testHandleConflictException()
    {
        $handler = new ExceptionHandler();
        $exception = new ConflictException('Conflicto');

        $response = $handler->handle($exception);

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
    }

    public function testHandleGenericException()
    {
        $handler = new ExceptionHandler();
        $exception = new \Exception('Error genérico');

        $response = $handler->handle($exception);

        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
