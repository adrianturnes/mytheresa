<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity\Promotion;

use App\Store\Domain\Entity\Product\Product;

abstract class Promotion
{
    protected int $id;
    protected int $percentage;
    abstract public function shouldBeApplied(Product $product): bool;
    public function percentage(): int
    {
        return $this->percentage;
    }
}
