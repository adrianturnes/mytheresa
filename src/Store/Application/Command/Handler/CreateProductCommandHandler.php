<?php

declare(strict_types=1);

namespace App\Store\Application\Command\Handler;

use App\Store\Application\Command\CreateProductCommand;
use App\Store\Domain\Entity\Product\Price;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Repository\ProductRepository;

class CreateProductCommandHandler
{
    public function __construct(
        private ProductRepository $repository
    )
    {
    }

    public function handle(CreateProductCommand $command): void
    {

        $price = Price::create($command->price());
        $product = Product::create(
            $command->sku(),
            $command->name(),
            $command->category(),
            $price
        );

        $this->repository->save($product);

    }
}
