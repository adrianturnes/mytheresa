<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Application\Query\Handler;

use App\Shared\Domain\ValueObject\Paginate;
use App\Shared\Domain\ValueObject\PaginationResult;
use App\Store\Application\Query\GetProductListQuery;
use App\Store\Application\Query\Handler\GetProductListQueryHandler;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Repository\ProductRepository;
use App\Store\Domain\Repository\PromotionRepository;
use App\Store\Domain\Service\PromotionResolver;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetProductListQueryHandlerTest extends TestCase
{
    private MockObject|ProductRepository $productRepository;
    private MockObject|PromotionRepository $promotionRepository;
    private MockObject|PromotionResolver $promotionResolver;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->promotionRepository = $this->createMock(PromotionRepository::class);
        $this->promotionResolver = $this->createMock(PromotionResolver::class);

        $this->handler = new GetProductListQueryHandler(
            $this->productRepository,
            $this->promotionRepository,
            $this->promotionResolver
        );
    }

    public function testHandleReturnsPaginatedProductsWithResolvedPromotions(): void
    {
        $query = GetProductListQuery::create('boots', '100', '1', '10');

        $paginate = Paginate::create(1, 10);

        $products = [
            $this->createMock(Product::class),
            $this->createMock(Product::class)
        ];

        $paginationResult = $this->createMock(PaginationResult::class);
        $paginationResult->method('items')->willReturn($products);

        $this->productRepository->expects($this->once())
            ->method('findByFilters')
            ->with('boots', 100, $paginate)
            ->willReturn($paginationResult);

        $promotions = [$this->createMock(\stdClass::class)];

        $this->promotionRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($promotions);

        $this->promotionResolver->expects($this->exactly(2))
            ->method('resolvePromotion');

        $result = $this->handler->handle($query);

        $this->assertSame($paginationResult, $result);
    }
}
