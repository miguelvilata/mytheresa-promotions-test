<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Interface\Repository;
use App\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProductMysqlRepository extends ServiceEntityRepository implements Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}