<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity\Product;

class Product
{
    public function __construct(
        private string $sku,
        private string $name,
        private string $category,
        private Price  $price
    ) {}

    public static function create(
        string $sku,
        string $name,
        string $category,
        Price  $price
    ): self {
        return new self($sku, $name, $category, $price);
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function price(): Price
    {
        return $this->price;
    }
}
