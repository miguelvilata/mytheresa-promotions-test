<?php
declare(strict_types=1);

namespace App\Api\Action\Product\Handler;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Action\Product\ViewModel\ListProductView;
use App\Api\Shared\Domain\Services\Pricing\PriceCalculator;
use App\Domain\Interface\Repository;
use App\Api\Shared\Domain\Interface\CommandHandler;
use App\Infrastructure\Repository\ProductMysqlRepository;

class ListProductCommandHandler implements CommandHandler
{
    private Repository $productRepository;

    public function __construct(ProductMysqlRepository $productRepository, PriceCalculator $priceCalculator)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ListProductCommand $command)
    {
        $products = $this->productRepository->findAll();

        return (new ListProductView($products))->render();
    }
}
