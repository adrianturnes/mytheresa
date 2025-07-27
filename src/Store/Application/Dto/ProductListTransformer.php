<?php

declare(strict_types=1);

namespace App\Store\Application\Dto;

use App\Shared\Application\Dto\Transformer;
use App\Store\Domain\Entity\Product\Product;

class ProductListTransformer implements Transformer
{
    public function __construct(private ProductTransformer $productTransformer)
    {
    }

    /** @param Product[] $data */
    public function transform($data): array
    {
        $result = [
        ];
        foreach($data as $product) {
            $result[] = $this->productTransformer->transform($product);
        }
        return $result;
    }
}
