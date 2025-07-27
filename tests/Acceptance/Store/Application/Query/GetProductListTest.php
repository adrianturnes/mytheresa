<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Store\Application\Query;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetProductListTest extends WebTestCase
{
    public function testProductListWithFilters(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products?category=boots&priceLessThan=90000&page=1&limit=2');
        $this->assertResponseIsSuccessful();
        $this->assertSame(json_encode([
            'total' => 2,
            'page' => 1,
            'total_pages' => 1,
            'limit' => 2,
            'items' => [
                [
                    'sku' => '000001',
                    'name' => 'BV Lean leather ankle boots',
                    'category' => 'boots',
                    'price' => [
                        "original" => 89000,
                        "final" => 62300,
                        "discount_percentage" => "30%",
                        "currency" => "EUR",

                    ],
                ],
                [
                    'sku' => '000003',
                    "name" => "Ashlington leather ankle boots",
                    "category" => "boots",
                    'price' => [
                        "original" => 71000,
                        "final" => 49700,
                        "discount_percentage" => "30%",
                        "currency" => "EUR",

                    ],
                ]
            ],

        ]), $client->getResponse()->getContent());
    }

    public function testGetProductListWithoutFilters(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products');
        $this->assertResponseIsSuccessful();
        $this->assertCount(5, json_decode($client->getResponse()->getContent(), true)['items']);
    }
}
