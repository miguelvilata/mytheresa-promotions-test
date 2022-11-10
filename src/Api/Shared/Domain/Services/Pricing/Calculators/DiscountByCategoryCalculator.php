<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing\Calculators;

use App\Api\Shared\Domain\Interface\PriceCalculator;
use App\Api\Shared\Dto\CalculatorResult;
use App\Domain\Entity\Product;

class DiscountByCategoryCalculator implements PriceCalculator
{
    const CATEGORIES = ['boots',];
    const DEFAULT_DISCOUNT = 30;

    public function supports(Product $product): bool
    {
        return in_array($product->getCategory(), self::CATEGORIES);
    }

    public function calculate(Product $product): CalculatorResult
    {
        $productPrice = $product->getPrice();
        $discount = $productPrice * (self::DEFAULT_DISCOUNT / 100);
        $t = $discount * -1;

        return new CalculatorResult(
            $this->getName(),
            (int)$t,
            $this->getCategory(),
            self::DEFAULT_DISCOUNT
        );
    }

    public function order(): int
    {
        return 10;
    }

    public function getCategory(): string
    {
        return 'discount_percentage';
    }

    public function getName(): string
    {
        return 'DiscountByCategoryCalculator';
    }
}