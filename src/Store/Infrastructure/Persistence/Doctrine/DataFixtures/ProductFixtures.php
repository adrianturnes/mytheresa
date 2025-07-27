<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Store\Domain\Entity\Product\Price;
use App\Store\Domain\Entity\Product\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PRODUCT_1_SKU = '000001';
    public const PRODUCT_1_NAME = 'BV Lean leather ankle boots';
    public const PRODUCT_1_CATEGORY = 'boots';
    public const PRODUCT_1_PRICE = 89000;
    public const PRODUCT_2_SKU = '000002';
    public const PRODUCT_2_NAME = 'BV Lean leather ankle boots';
    public const PRODUCT_2_CATEGORY = 'boots';
    public const PRODUCT_2_PRICE = 99000;
    public const PRODUCT_3_SKU = '000003';
    public const PRODUCT_3_NAME = 'Ashlington leather ankle boots';
    public const PRODUCT_3_CATEGORY = 'boots';
    public const PRODUCT_3_PRICE = 71000;
    public const PRODUCT_4_SKU = '000004';
    public const PRODUCT_4_NAME = 'Naima embellished suede sandals';
    public const PRODUCT_4_CATEGORY = 'sandals';
    public const PRODUCT_4_PRICE = 79500;
    public const PRODUCT_5_SKU = '000005';
    public const PRODUCT_5_NAME = 'Nathane leather sneakers';
    public const PRODUCT_5_CATEGORY = 'sneakers';
    public const PRODUCT_5_PRICE = 59000;
    public function load(ObjectManager $manager): void
    {
        $this->createProduct1($manager);
        $this->createProduct2($manager);
        $this->createProduct3($manager);
        $this->createProduct4($manager);
        $this->createProduct5($manager);
    }

    private function createProduct1($manager): void
    {
        $product = Product::create(
            self::PRODUCT_1_SKU,
            self::PRODUCT_1_NAME,
            self::PRODUCT_1_CATEGORY,
            Price::create(self::PRODUCT_1_PRICE),
        );
        $manager->persist($product);
        $manager->flush();
    }

    private function createProduct2($manager): void
    {
        $product = Product::create(
            self::PRODUCT_2_SKU,
            self::PRODUCT_2_NAME,
            self::PRODUCT_2_CATEGORY,
            Price::create(self::PRODUCT_2_PRICE),
        );
        $manager->persist($product);
        $manager->flush();
    }

    private function createProduct3($manager): void
    {
        $product = Product::create(
            self::PRODUCT_3_SKU,
            self::PRODUCT_3_NAME,
            self::PRODUCT_3_CATEGORY,
            Price::create(self::PRODUCT_3_PRICE),
        );
        $manager->persist($product);
        $manager->flush();
    }

    private function createProduct4($manager): void
    {
        $product = Product::create(
            self::PRODUCT_4_SKU,
            self::PRODUCT_4_NAME,
            self::PRODUCT_4_CATEGORY,
            Price::create(self::PRODUCT_4_PRICE),
        );
        $manager->persist($product);
        $manager->flush();
    }

    private function createProduct5($manager): void
    {
        $product = Product::create(
            self::PRODUCT_5_SKU,
            self::PRODUCT_5_NAME,
            self::PRODUCT_5_CATEGORY,
            Price::create(self::PRODUCT_5_PRICE),
        );
        $manager->persist($product);
        $manager->flush();
    }
}
