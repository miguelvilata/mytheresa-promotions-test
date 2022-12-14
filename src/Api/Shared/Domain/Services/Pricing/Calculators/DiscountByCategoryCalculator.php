<?php

declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing\Calculators;

use App\Api\Shared\Domain\Interface\PriceCalculatorCommandInterface;
use App\Api\Shared\Dto\CalculatorResult;
use App\Domain\Entity\Product;

final class DiscountByCategoryCalculator implements PriceCalculatorCommandInterface
{
    private const CATEGORIES = ['boots',];
    private const DEFAULT_DISCOUNT = 30;

    public function supports(Product $product): bool
    {
        return in_array($product->getCategory(), self::CATEGORIES);
    }

    public function calculate(Product $product): CalculatorResult
    {
        $productPrice = $product->getPrice();
        $discount = $productPrice * (self::DEFAULT_DISCOUNT / 100);

        return new CalculatorResult(
            $this->getName(),
            (int)$discount,
            $this->getCategory(),
            self::DEFAULT_DISCOUNT
        );
    }

    public function getCategory(): string
    {
        return PriceCalculatorCommandInterface::CALCULATOR_DISCOUNT_TYPE;
    }

    public function getName(): string
    {
        return 'DiscountByCategoryCalculator';
    }
}
