<?php

declare(strict_types=1);

namespace App\Store\Application\Dto;

use App\Shared\Application\Dto\Transformer;
use App\Store\Domain\Entity\Product\Product;

class ProductTransformer implements Transformer
{
    /** @param Product $data */
    public function transform($data): array
    {
        return [
            'sku' => $data->sku(),
            'name' => $data->name(),
            'category' => $data->category(),
            'price' => [
                'original' => $data->price()->priceOriginal(),
                'final' => $data->price()->priceFinal(),
                'discount_percentage' => $data->price()->promotionPercentage() ? $data->price()->promotionPercentage() . '%' : null,
                'currency' => $data->price()->currency(),
            ],
        ];
    }
}
