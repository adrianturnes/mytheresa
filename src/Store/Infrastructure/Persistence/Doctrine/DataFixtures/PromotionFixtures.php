<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Store\Domain\Entity\Promotion\CategoryPromotion;
use App\Store\Domain\Entity\Promotion\SkuPromotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromotionFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $categoryPromotion = CategoryPromotion::create('boots', 30);
        $skuPromotion = SkuPromotion::create('000003', 15);

        $manager->persist($categoryPromotion);
        $manager->persist($skuPromotion);
        $manager->flush();
    }
}
