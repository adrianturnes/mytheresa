<?php

declare(strict_types=1);

namespace App\Store\Application\Command;

class CreateProductListCommand
{
    private function __construct(
        private array $productList = []
    ) {}
    public static function createFromArray(array $data): self
    {
        return new self($data['products']);
    }

    public function productList(): array
    {
        return $this->productList;
    }
}
