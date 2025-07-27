<?php

declare(strict_types=1);

namespace App\Store\Application\Command\Handler;

use App\Store\Application\Command\CreateProductCommand;
use App\Store\Application\Command\CreateProductListCommand;

class CreateProductListCommandHandler
{
    public function __construct(
        private CreateProductCommandHandler $createProductCommandHandler
    ) {}

    public function handle(CreateProductListCommand $command): void
    {
        foreach ($command->productList() as $productToCreate) {
            $command = new CreateProductCommand(
                $productToCreate['sku'],
                $productToCreate['name'],
                $productToCreate['category'],
                $productToCreate['price']
            );

            $this->createProductCommandHandler->handle($command);
        }
    }
}
