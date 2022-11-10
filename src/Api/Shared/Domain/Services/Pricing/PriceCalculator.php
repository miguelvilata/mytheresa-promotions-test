<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing;

use App\Api\Shared\Dto\PriceCalculatorResult;
use App\Domain\Entity\Product;

final class PriceCalculator
{
    const CURRENCY = 'EUR';

    public function __construct(private iterable $calculators)
    {}

    public function calculate(Product $product): PriceCalculatorResult
    {
        $priceCalculatorResult = new PriceCalculatorResult($product);

        foreach ($this->calculators as $calculator) {
            if (!$calculator->supports($product)) {
                continue;
            }

            $priceCalculatorResult->addLine($calculator->calculate($product));
        }

        $sku = $product->getSku();

        $t = $priceCalculatorResult->getLines();

        return $priceCalculatorResult;
    }
}