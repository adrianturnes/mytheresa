<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Service;

use App\Store\Domain\Entity\Product\Price;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Entity\Promotion\CategoryPromotion;
use App\Store\Domain\Entity\Promotion\SkuPromotion;
use App\Store\Domain\Service\PromotionResolver;
use PHPUnit\Framework\TestCase;

class PromotionResolverTest extends TestCase
{
    public function testResolveReturnsExpectedPromotion(): void
    {
        $product = Product::create('000003', 'Ashlington leather ankle boots', 'boots', Price::create(71000));
        $promotion1 = CategoryPromotion::create('boots', 30);
        $promotion2 = SkuPromotion::create('000003', 15);

        // Instancia el resolver real
        $promotionResolver = new PromotionResolver();
        $promotionResolver->resolvePromotion($product, [$promotion1, $promotion2]);

        $this->assertEquals(30, $product->price()->promotionPercentage());
        $this->assertEquals(49700, $product->price()->priceFinal());

    }
}
