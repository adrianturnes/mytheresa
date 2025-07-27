<?php

declare(strict_types=1);

namespace App\Store\Domain\Repository;

interface PromotionRepository
{
    public function findAll(): array;
}
