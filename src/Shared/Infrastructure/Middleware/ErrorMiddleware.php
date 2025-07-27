<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Middleware;

use App\Shared\UserInterface\Http\ExceptionHandler;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ErrorMiddleware
{
    public function __construct(private ExceptionHandler $exceptionHandler)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $event->setResponse($this->exceptionHandler->handle($event->getThrowable()));
    }
}
