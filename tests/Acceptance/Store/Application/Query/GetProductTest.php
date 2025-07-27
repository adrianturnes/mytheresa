<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Store\Application\Query;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetProductTest extends WebTestCase
{
    public function testHappyPath(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products/000002');
        $this->assertResponseIsSuccessful();
        $this->assertSame(json_encode([
            "sku" => "000002",
            "name" => "BV Lean leather ankle boots",
            "category" => "boots",
            'price' => [
                "original" => 99000,
                "final" => 69300,
                "discount_percentage" => "30%",
                "currency" => "EUR",

            ],
        ]), $client->getResponse()->getContent());
    }

    public function testNotFound(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products/000010');
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_NOT_FOUND);
        $this->assertStringContainsString(
            'Product with SKU \u0022000010\u0022 not found.',
            $client->getResponse()->getContent()
        );

    }
}
