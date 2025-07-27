<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Store\Application\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateProductListTest extends WebTestCase
{
    public function testCreateMultipleProducts(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'products' => [
                [
                    "sku" => "000501",
                    "name" => "BV Lean leather ankle boots",
                    "category" => "boots",
                    "price" => 89000,
                ],
                [
                    "sku" => "000502",
                    "name" => "BV Lean leather ankle boots",
                    "category" => "boots",
                    "price" => 99000
                ],
                [
                    "sku" => "000503",
                    "name" => "Ashlington leather ankle boots",
                    "category" => "boots",
                    "price" => 71000
                ],
                [
                    "sku" => "000504",
                    "name" => "Naima embellished suede sandals",
                    "category" => "sandals",
                    "price" => 79500,
                ],
                [
                    "sku" => "000505",
                    "name" => "Nathane leather sneakers",
                    "category" => "sneakers",
                    "price" => 59000,
                ]
            ],
        ]));

        $this->assertResponseIsSuccessful();
    }

    public function testCreateRepeatedProduct(): void
    {
        $client = static::createClient();
        $client->request('POST', '/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'products' => [
                [
                    "sku" => "000501",
                    "name" => "BV Lean leather ankle boots",
                    "category" => "boots",
                    "price" => 89000,
                ],
                [
                    "sku" => "000501",
                    "name" => "BV Lean leather ankle boots",
                    "category" => "boots",
                    "price" => 89000,
                ],
            ],
        ]));

        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_CONFLICT);
        $this->assertStringContainsString(
            'Product with SKU \u0022000501\u0022 already exists.',
            $client->getResponse()->getContent()
        );
    }
}
