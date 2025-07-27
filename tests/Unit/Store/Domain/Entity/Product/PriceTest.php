<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Entity\Product;

use App\Store\Domain\Entity\Product\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testCanCreateAProduct(): void
    {
        $price = Price::create(10000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(10000, $price->priceOriginal());
        $this->assertEquals(10000, $price->priceFinal());
        $this->assertNull($price->promotionPercentage());
        $this->assertEquals('EUR', $price->currency());
    }

    public function testCreateWithFinalPriceAndPromotion(): void
    {
        $price = Price::create(1000, 800, 20);

        $this->assertEquals(1000, $price->priceOriginal());
        $this->assertEquals(800, $price->priceFinal());
        $this->assertEquals(20, $price->promotionPercentage());
    }

    public function testApplyPromotion(): void
    {
        $price = Price::create(2000);
        $price->applyPromotion(25);

        $this->assertEquals(1500, $price->priceFinal());
        $this->assertEquals(25, $price->promotionPercentage());
    }

}
