<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity\Promotion;

use App\Store\Domain\Entity\Product\Product;

class CategoryPromotion extends Promotion
{
    private function __construct(private string $category, int $percentage)
    {
        $this->percentage = $percentage;
    }

    public static function create(string $category, int $percentage): self
    {
        return new self($category, $percentage);
    }

    public function shouldBeApplied(Product $product): bool
    {
        return $product->category() === $this->category;
    }
}
