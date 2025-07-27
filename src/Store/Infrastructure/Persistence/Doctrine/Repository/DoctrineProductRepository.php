<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Persistence\Doctrine\Repository;

use App\Shared\Domain\ValueObject\Paginate;
use App\Shared\Domain\ValueObject\PaginationResult;
use App\Store\Domain\Entity\Product\Product;
use App\Store\Domain\Exception\ProductAlreadyExistsException;
use App\Store\Domain\Exception\ProductNotFoundException;
use App\Store\Domain\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\EntityIdentityCollisionException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findByFilters(?string $category, ?int $priceLessThan, Paginate $paginate): PaginationResult
    {
        $queryBuilder = $this->createQueryBuilder('q');
        if ($category !== null) {
            $queryBuilder->andWhere('q.category = :category')
                ->setParameter('category', $category);
        }
        if ($priceLessThan !== null) {
            $queryBuilder->andWhere('q.price.priceOriginal <= :priceLessThan')
                ->setParameter('priceLessThan', $priceLessThan);
        }

        $queryBuilder->setFirstResult(($paginate->page() - 1) * $paginate->limit())
            ->setMaxResults($paginate->limit());

        $paginator = new Paginator($queryBuilder);
        $items = iterator_to_array($paginator);
        $total = count($paginator);

        return new PaginationResult($items, $total, $paginate->page(), $paginate->limit());
    }

    public function findOrFailBySku(string $sku): Product
    {
        $product = $this->find($sku);
        if (!$product) {
            throw new ProductNotFoundException($sku);
        }
        return $product;
    }

    public function save(Product $product): void
    {
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (EntityIdentityCollisionException $exception) {
            throw new ProductAlreadyExistsException($product->sku());
        }
    }
}
