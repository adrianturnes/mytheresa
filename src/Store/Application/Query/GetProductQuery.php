<?php

declare(strict_types=1);

namespace App\Store\Application\Query;

class GetProductQuery
{
    private function __construct(private string $sku)
    {
    }

    public static function create(string $sku): self
    {
        return new self($sku);
    }

    public function sku(): string
    {
        return $this->sku;
    }
}
