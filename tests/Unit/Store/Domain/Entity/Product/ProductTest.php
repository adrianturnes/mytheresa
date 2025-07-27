<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Entity\Product;

use App\Store\Domain\Entity\Product\Price;
use App\Store\Domain\Entity\Product\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCanCreateAProduct(): void
    {
        $price = Price::create(10000);
        $product = Product::create(
            '000001',
            'Test Product',
            'trousers',
            $price,
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('000001', $product->sku());
        $this->assertEquals('Test Product', $product->name());
        $this->assertEquals('trousers', $product->category());
        $this->assertSame($price, $product->price());
    }
}
