<?php
declare(strict_types=1);

namespace App\Api\Action\Product\Handler;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Shared\Domain\Interface\CommandHandler;
use App\Domain\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ListProductCommandHandler implements CommandHandler
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(ListProductCommand $command)
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        foreach ($products as $product) {
            return $product->getSku();
        }

        return $command->text;
    }
}
