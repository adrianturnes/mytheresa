<?php

declare(strict_types=1);

namespace App\Store\Domain\Entity\Product;

class Price
{
    private const CURRENCY = 'EUR';

    private function __construct(
        private int  $priceOriginal,
        private ?int $priceFinal,
        private ?int $promotionPercentage
    ) {
    }

    public static function create(
        int      $priceOriginal,
        ?int $finalPrice = null,
        ?int $promotionPercentage = null
    ): self
    {
        return new self($priceOriginal, $finalPrice, $promotionPercentage);
    }

    public function priceOriginal(): int
    {
        return $this->priceOriginal;
    }

    public function priceFinal(): int
    {
        if(!isset($this->priceFinal)) {
            return $this->priceOriginal;
        }
        return $this->priceFinal;
    }

    public function promotionPercentage(): int|null
    {
        if(!isset($this->promotionPercentage)) {
            return null;
        }
        return $this->promotionPercentage;
    }

    public function applyPromotion(int $promotionPercentage): void
    {
        $this->promotionPercentage = $promotionPercentage;
        $this->priceFinal = (int)round($this->priceOriginal * (1 - ($promotionPercentage / 100)));
    }

    public function currency(): string
    {
        return self::CURRENCY;
    }
}
