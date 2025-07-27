<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Exception;

use App\Store\Domain\Exception\ProductNotFoundException;
use PHPUnit\Framework\TestCase;

class ProductNotFoundExceptionTest extends TestCase
{
    public function testExceptionMessage(): void
    {
        $sku = '000001';
        $exception = new ProductNotFoundException($sku);

        $this->assertInstanceOf(ProductNotFoundException::class, $exception);
        $this->assertSame('Product with SKU "000001" not found.', $exception->getMessage());
    }
}
