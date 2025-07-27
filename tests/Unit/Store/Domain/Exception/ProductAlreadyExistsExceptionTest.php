<?php

declare(strict_types=1);

namespace App\Tests\Unit\Store\Domain\Exception;

use App\Store\Domain\Exception\ProductAlreadyExistsException;
use PHPUnit\Framework\TestCase;

class ProductAlreadyExistsExceptionTest extends TestCase
{
    public function testExceptionMessage(): void
    {
        $sku = '000001';
        $exception = new ProductAlreadyExistsException($sku);

        $this->assertInstanceOf(ProductAlreadyExistsException::class, $exception);
        $this->assertSame('Product with SKU "000001" already exists.', $exception->getMessage());
    }
}
