<?php

declare(strict_types=1);

namespace App\Store\Domain\Repository;

use App\Shared\Domain\ValueObject\Paginate;
use App\Shared\Domain\ValueObject\PaginationResult;
use App\Store\Domain\Entity\Product\Product;

interface ProductRepository
{
    public function findByFilters(?string $category, ?int $priceLessThan, Paginate $paginate): PaginationResult;
    public function findOrFailBySku(string $sku): Product;
    public function save(Product $product): void;
}
