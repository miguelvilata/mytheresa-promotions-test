<?php
declare(strict_types=1);

namespace App\Api\Action\Product\Handler;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Shared\Domain\Services\Pricing\PriceCalculator;
use App\Api\Shared\Domain\Interface\CommandHandler;
use App\Infrastructure\Repository\ProductMysqlRepository;

class ListProductCommandHandler implements CommandHandler
{
    public function __construct(private ProductMysqlRepository $productRepository, private PriceCalculator $priceCalculator)
    {}

    public function __invoke(ListProductCommand $command)
    {
        $result = [];
        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            $calculatorResult = $this->priceCalculator->calculate($product);
//            $productResult = (new ProductView($product, $calculatorResult))->render();
//            $result[] = $productResult;
        }

        return $result;
        //return (new ListProductView($products))->render();
    }
}
