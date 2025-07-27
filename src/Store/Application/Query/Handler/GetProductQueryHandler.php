<?php

declare(strict_types=1);

namespace App\Store\Application\Query\Handler;

use App\Store\Application\Query\GetProductQuery;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Repository\ProductRepository;
use App\Store\Domain\Repository\PromotionRepository;
use App\Store\Domain\Service\PromotionResolver;

class GetProductQueryHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private PromotionRepository $promotionRepository,
        private PromotionResolver $promotionResolver
    ) {}

    public function handle(GetProductQuery $query): Product
    {
        $product = $this->productRepository->findOrFailBySku($query->sku());
        $promotions = $this->promotionRepository->findAll();

        $this->promotionResolver->resolvePromotion($product, $promotions);

        return $product;
    }
}
