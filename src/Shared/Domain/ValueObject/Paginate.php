<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class Paginate
{
    private const DEFAULT_LIMIT = 5;
    private function __construct(private int $page, private int $limit)
    {
    }

    public static function create(?int $page, ?int $limit): self
    {
        return new self(
            $page ?? 1,
            $limit ?? self::DEFAULT_LIMIT
        );
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
