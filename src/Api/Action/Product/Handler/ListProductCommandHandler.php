<?php

declare(strict_types=1);

namespace App\Api\Action\Product\Handler;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Action\Product\ViewModel\ProductView;
use App\Api\Shared\Domain\Interface\CommandHandlerInterface;
use App\Api\Shared\Domain\Interface\PriceCalculatorInterface;
use App\Domain\Interface\ProductRepositoryInterface;

class ListProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository, private PriceCalculatorInterface $priceCalculator)
    {
    }

    public function __invoke(ListProductCommand $command)
    {
        $result = [];
        $products = $this->productRepository->filter(
            $command->getFilters()
        );

        foreach ($products as $product) {
            $priceResult = $this->priceCalculator->calculate($product);
            $productResult = (new ProductView($product, $priceResult))->render();
            $result[] = $productResult;
        }

        return $result;
    }
}
