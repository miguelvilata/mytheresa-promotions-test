<?php

declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing\Calculators;

use App\Api\Shared\Domain\Interface\PriceCalculatorCommandInterface;
use App\Api\Shared\Dto\CalculatorResult;
use App\Domain\Entity\Product;

final class BasePriceCalculator implements PriceCalculatorCommandInterface
{
    public function supports(Product $product): bool
    {
        return true;
    }

    public function calculate(Product $product): CalculatorResult
    {
        return new CalculatorResult(
            $this->getName(),
            $product->getPrice(),
            $this->getCategory()
        );
    }

    public function getCategory(): string
    {
        return PriceCalculatorCommandInterface::CALCULATOR_BASE_TYPE;
    }

    public function getName(): string
    {
        return 'BasePriceCalculator';
    }
}
