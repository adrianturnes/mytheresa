<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Application\Query\Handler;

use App\Store\Application\Query\GetProductQuery;
use App\Store\Application\Query\Handler\GetProductQueryHandler;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Repository\ProductRepository;
use App\Store\Domain\Repository\PromotionRepository;
use App\Store\Domain\Service\PromotionResolver;
use PHPUnit\Framework\TestCase;

class GetProductQueryHandlerTest extends TestCase
{
    public function testHandleReturnsProductWithResolvedPromotions(): void
    {
        $sku = 'SKU123';
        $query = GetProductQuery::create($sku);

        $product = $this->createMock(Product::class);
        $promotions = [$this->createMock(\stdClass::class)];
        $productRepository = $this->createMock(ProductRepository::class);
        $promotionRepository = $this->createMock(PromotionRepository::class);
        $promotionResolver = $this->createMock(PromotionResolver::class);

        $handler = new GetProductQueryHandler(
            $productRepository,
            $promotionRepository,
            $promotionResolver
        );

        $productRepository->expects($this->once())
            ->method('findOrFailBySku')
            ->with($sku)
            ->willReturn($product);

        $promotionRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($promotions);

        $promotionResolver->expects($this->once())
            ->method('resolvePromotion')
            ->with($product, $promotions);

        $result = $handler->handle($query);

        $this->assertSame($product, $result);
    }
}
