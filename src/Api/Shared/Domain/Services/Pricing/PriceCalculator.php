<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing;

use App\Api\Shared\Dto\PriceCalculatorResult;
use App\Domain\Entity\Product;

final class PriceCalculator
{
    public function __construct(private iterable $calculators)
    {}

    public function calculate(Product $product): PriceCalculatorResult
    {
        $finalPrice = $product->getPrice();
        $lines = [];

        foreach ($this->calculators as $calculator) {
            if (!$calculator->supports($product, $lines)) {
                continue;
            }

            $operation = $calculator->calculate($product);

            $line = [
                'name' => $calculator->getName(),
                'calculator' => $operation,
            ];

            $lines[$calculator->getCategory()] = $line;

            $finalPrice = $finalPrice + $operation->amount;
        }

        return new PriceCalculatorResult(
            $product->getPrice(),
            0,
            20
        );
    }
}