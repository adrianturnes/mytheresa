<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity\Promotion;

use App\Store\Domain\Entity\Product\Product;

class SkuPromotion extends Promotion
{

    private function __construct(private string $sku, int $percentage)
    {
        $this->percentage = $percentage;
    }

    public static function create(string $sku, int $percentage): self
    {
        return new self($sku, $percentage);
    }

    public function shouldBeApplied(Product $product): bool
    {
        return $product->sku() === $this->sku;
    }
}
