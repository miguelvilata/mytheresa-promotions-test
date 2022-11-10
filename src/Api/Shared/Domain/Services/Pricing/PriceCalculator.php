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
        $finalPrice = null;
        $lines = [];

        foreach ($this->calculators as $calculator) {
            if (!$calculator->supports($product, $lines)) {
                continue;
            }

            $line = [
                'name' => $calculator->getName(),
                'amount' => $calculator->calculate($product),
            ];

            $lines[$calculator->getCategory()] = $line;
        }

        return new PriceCalculatorResult(
            $product->getPrice(),
            0,
            20
        );
    }
}