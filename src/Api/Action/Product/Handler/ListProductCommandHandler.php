<?php
declare(strict_types=1);

namespace App\Api\Action\Product\Handler;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Action\Product\ViewModel\ListProductView;
use App\Api\Shared\Domain\Services\Pricing\PriceCalculator;
use App\Api\Shared\Domain\Interface\CommandHandler;
use App\Infrastructure\Repository\ProductMysqlRepository;

class ListProductCommandHandler implements CommandHandler
{
    public function __construct(private ProductMysqlRepository $productRepository, private PriceCalculator $priceCalculator)
    {}

    public function __invoke(ListProductCommand $command)
    {
        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            $t = $this->priceCalculator->calculate($product);
        }

        return (new ListProductView($products))->render();
    }
}
