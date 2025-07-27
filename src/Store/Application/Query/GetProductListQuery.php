<?php

declare(strict_types=1);

namespace App\Store\Application\Query;

class GetProductListQuery
{
    private function __construct(private ?string $category, private ?int $priceLessThan, private ?int $page = null, private ?int $limit = null)
    {
    }

    public static function create(?string $category = null, ?string $priceLessThan = null, ?string $page = null, ?string $limit = null): self
    {
        return new self(
            $category,
            $priceLessThan ? intval($priceLessThan) : null,
            $page ? intval($page) : null,
            $limit ? intval($limit) : null
        );
    }

    public function category(): ?string
    {
        return $this->category;
    }

    public function priceLessThan(): ?int
    {
        return $this->priceLessThan;
    }

    public function page(): ?int
    {
        return $this->page;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }
}
