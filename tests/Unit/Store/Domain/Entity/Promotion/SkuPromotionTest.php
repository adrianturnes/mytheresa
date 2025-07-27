<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Entity\Promotion;

use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Entity\Promotion\SkuPromotion;
use PHPUnit\Framework\TestCase;

class SkuPromotionTest extends TestCase
{
    public function testCanCreateASkuPromotion(): void
    {
        $promotion = SkuPromotion::create('000001', 20);
        $this->assertInstanceOf(SkuPromotion::class, $promotion);
        $this->assertEquals(20, $promotion->percentage());
    }

    public function testShouldBeAppliedToProductWithSku(): void
    {
        $promotion = SkuPromotion::create('000001', 20);
        $product = $this->createMock(Product::class);
        $product->method('sku')->willReturn('000001');

        $this->assertTrue($promotion->shouldBeApplied($product));
    }

    public function testShouldNotBeAppliedToProductWithDifferentSku(): void
    {
        $promotion = SkuPromotion::create('000001', 20);
        $product = $this->createMock(Product::class);
        $product->method('sku')->willReturn('000002');

        $this->assertFalse($promotion->shouldBeApplied($product));
    }
}
