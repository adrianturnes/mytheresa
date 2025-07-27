<?php

declare(strict_types=1);

namespace App\Store\Application\Query\Handler;

use App\Shared\Domain\ValueObject\Paginate;
use App\Shared\Domain\ValueObject\PaginationResult;
use App\Store\Application\Query\GetProductListQuery;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Repository\ProductRepository;
use App\Store\Domain\Repository\PromotionRepository;
use App\Store\Domain\Service\PromotionResolver;

class GetProductListQueryHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private PromotionRepository $promotionRepository,
        private PromotionResolver $promotionResolver
    ) {}

    public function handle(GetProductListQuery $query): PaginationResult
    {
        $paginate = Paginate::create($query->page(), $query->limit());
        $products = $this->productRepository->findByFilters($query->category(), $query->priceLessThan(), $paginate);
        $promotions = $this->promotionRepository->findAll();

        /** @var Product $product */
        foreach ($products->items() as $product) {
            $this->promotionResolver->resolvePromotion($product, $promotions);
        }

        return $products;
    }
}
