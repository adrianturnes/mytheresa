<?php

declare(strict_types=1);

namespace App\Shared\Application\Dto;

use App\Shared\Domain\ValueObject\PaginationResult;

class PaginatorTransformer
{
    public function transform(PaginationResult $paginationResult, Transformer $transformer)
    {
        return [
            'total' => $paginationResult->total(),
            'page' => $paginationResult->page(),
            'total_pages' => (int) ceil($paginationResult->total() / $paginationResult->limit()),
            'limit' => $paginationResult->limit(),
            'items' => $transformer->transform($paginationResult->items()),
        ];
    }
}
