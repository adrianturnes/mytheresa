<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Application\Dto;

use App\Store\Application\Dto\ProductTransformer;
use App\Store\Domain\Entity\Product\Price;
use App\Store\Domain\Entity\Product\Product;
use PHPUnit\Framework\TestCase;

class ProductTransformerTest extends TestCase
{
    public function testTransform()
    {
        $price = Price::create(100, 80, 20, 'EUR');
        $product = Product::create('SKU123', 'Producto Test', 'Categoría', $price);

        $transformer = new ProductTransformer();
        $result = $transformer->transform($product);

        $expected = [
            'sku' => 'SKU123',
            'name' => 'Producto Test',
            'category' => 'Categoría',
            'price' => [
                'original' => 100,
                'final' => 80,
                'discount_percentage' => '20%',
                'currency' => 'EUR',
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
