<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Application\Dto;

use App\Store\Application\Dto\ProductListTransformer;
use App\Store\Application\Dto\ProductTransformer;
use App\Store\Domain\Entity\Product\Product;
use PHPUnit\Framework\TestCase;

class ProductListTransformerTest extends TestCase
{
    public function testTransformReturnsTransformedProductsArray(): void
    {
        $product1 = $this->createMock(Product::class);
        $product2 = $this->createMock(Product::class);

        $productTransformer = $this->createMock(ProductTransformer::class);
        $productTransformer->expects($this->exactly(2))
            ->method('transform');

        $listTransformer = new ProductListTransformer($productTransformer);

        $result = $listTransformer->transform([$product1, $product2]);
    }
}
