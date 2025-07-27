<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Entity\Promotion;

use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Entity\Promotion\CategoryPromotion;
use PHPUnit\Framework\TestCase;

class CategoryPromotionTest extends TestCase
{
    public function testCanCreateACategoryPromotion(): void
    {
        $promotion = CategoryPromotion::create('boots', 20);
        $this->assertInstanceOf(CategoryPromotion::class, $promotion);
        $this->assertEquals(20, $promotion->percentage());
    }

    public function testShouldBeAppliedToProductInCategory(): void
    {
        $promotion = CategoryPromotion::create('boots', 20);
        $product = $this->createMock(Product::class);
        $product->method('category')->willReturn('boots');

        $this->assertTrue($promotion->shouldBeApplied($product));
    }

    public function testShouldNotBeAppliedToProductNotInCategory(): void
    {
        $promotion = CategoryPromotion::create('boots', 20);
        $product = $this->createMock(Product::class);
        $product->method('category')->willReturn('shoes');

        $this->assertFalse($promotion->shouldBeApplied($product));
    }
}
