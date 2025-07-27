<?php

declare(strict_types=1);

namespace App\Store\Domain\Exception;

use App\Shared\Domain\Exception\ConflictException;

class ProductAlreadyExistsException extends ConflictException
{
    public function __construct(string $sku)
    {
        parent::__construct(sprintf('Product with SKU "%s" already exists.', $sku));
    }
}
