<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Application\Command\Handler;

use App\Store\Application\Command\CreateProductCommand;
use App\Store\Application\Command\CreateProductListCommand;
use App\Store\Application\Command\Handler\CreateProductCommandHandler;
use App\Store\Application\Command\Handler\CreateProductListCommandHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateProductListCommandHandlerTest extends TestCase
{
    private MockObject|CreateProductCommandHandler $createProductCommandHandler;
    private CreateProductListCommandHandler $handler;

    public function setUp(): void
    {
        parent::setUp();
        $this->createProductCommandHandler = $this->createMock(CreateProductCommandHandler::class);
        $this->handler = new CreateProductListCommandHandler($this->createProductCommandHandler);
    }

    public function testHandleSavesProducts(): void
    {
        $command = CreateProductListCommand::createFromArray(
            [
                'products' => [
                    [
                        "sku" => "000001",
                        "name" => "BV Lean leather ankle boots",
                        "category" => "boots",
                        "price" => 89000,
                    ],
                    [
                        "sku" => "000002",
                        "name" => "BV Lean leather ankle boots",
                        "category" => "boots",
                        "price" => 99000
                    ],
                ],
            ]
        );

        $this->createProductCommandHandler->expects($this->exactly(2))
            ->method('handle')
            ->with($this->isInstanceOf(CreateProductCommand::class));

        $this->handler->handle($command);
    }
}
