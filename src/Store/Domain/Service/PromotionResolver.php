<?php

declare(strict_types=1);

namespace App\Store\Domain\Service;

use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Entity\Promotion\Promotion;

class PromotionResolver
{
    public function resolvePromotion(Product $product, array $promotions): void
    {
        $promotionToApply = 0;
        /** @var Promotion $promotion */
        foreach ($promotions as $promotion) {
            if($promotion->shouldBeApplied($product) && $promotion->percentage() > $promotionToApply) {
                $promotionToApply = $promotion->percentage();
            }
        }

        if($promotionToApply > 0) {
            $product->price()->applyPromotion($promotionToApply);
        }
    }
}
