<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Persistence\Doctrine\Repository;

use App\Store\Domain\Entity\Promotion\Promotion;
use App\Store\Domain\Repository\PromotionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrinePromotionRepository extends ServiceEntityRepository implements PromotionRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
