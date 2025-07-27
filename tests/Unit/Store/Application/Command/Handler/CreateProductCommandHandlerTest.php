<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Application\Command\Handler;

use App\Store\Application\Command\CreateProductCommand;
use App\Store\Application\Command\Handler\CreateProductCommandHandler;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Repository\ProductRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    private MockObject|ProductRepository $productRepository;
    private CreateProductCommandHandler $handler;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->handler = new CreateProductCommandHandler($this->productRepository);
    }

    public function testHandleSavesProduct(): void
    {
        $command = new CreateProductCommand(
            '000001',
            'BV Lean leather ankle boots',
            'Boots',
            89000
        );

        $this->productRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Product::class));

        $this->handler->handle($command);
    }
}
