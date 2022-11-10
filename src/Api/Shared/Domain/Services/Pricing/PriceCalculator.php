<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing;

use App\Api\Shared\Dto\PriceCalculatorResult;
use App\Domain\Entity\Product;

final class PriceCalculator
{
    public function calculate(Product $product): PriceCalculatorResult
    {

        return new PriceCalculatorResult();
    }
}