<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class PaginationResult
{
    public function __construct(
        private array $items,
        private int $total,
        private int $page,
        private int $limit
    ) {}

    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
