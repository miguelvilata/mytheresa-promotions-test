<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Interface\Repository;
use App\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductMysqlRepository extends ServiceEntityRepository implements Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function filter(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('p');
        $this->applyFilters($filters, $qb, 'p');

        return $qb->getQuery()->getResult();
    }

    protected function applyFilters(array &$filters, QueryBuilder &$qb = null, $alias = 'o')
    {
        $qb = $qb ?? $this->createQueryBuilder($alias);

        foreach ($filters as $filter => $value) {
            unset($filters[$filter]);
            switch ($filter) {
                case 'category':
                    $qb->andWhere("{$alias}.category = :category")
                        ->setParameter("category", $value);
                    break;
                case 'price_lt':
                    $qb->andWhere("{$alias}.price < :price")
                        ->setParameter('price', $value);
                    break;
            }
        }

        return $this;
    }
}
