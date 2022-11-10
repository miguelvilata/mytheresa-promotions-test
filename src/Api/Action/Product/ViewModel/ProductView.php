<?php
declare(strict_types=1);

namespace App\Api\Action\Product\ViewModel;

use App\Api\Shared\Dto\PriceCalculatorResult;
use App\Domain\Entity\Product;

final class ProductView
{
    public function __construct(private Product $product, private PriceCalculatorResult $calculatorResult)
    {}

    public function render()
    {
        return [
            'sku' => $this->product->getSku(),
            'name' => $this->product->getName(),
            'category' => $this->product->getCategory(),
            'price' => [
                'original' => $this->calculatorResult->getOriginalPrice(),
                'final' => $this->calculatorResult->getFinalPrice(),
                'discount_percentage' => $this->calculatorResult->getDiscountPercentage(),
                'currency' => $this->calculatorResult->getCurrency(),
            ],
        ];
    }
}