<?php

declare(strict_types=1);

namespace App\Store\Domain\Exception;

use App\Shared\Domain\Exception\NotFoundException;

class ProductNotFoundException extends NotFoundException
{
    public function __construct(string $sku)
    {
        parent::__construct(sprintf('Product with SKU "%s" not found.', $sku));
    }
}
