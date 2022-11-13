<?php

declare(strict_types=1);

namespace App\Api\Shared\Domain\Interface;

use App\Api\Shared\Dto\PriceCalculatorResult;
use App\Domain\Entity\Product;

interface PriceCalculatorInterface
{
    public function calculate(Product $product): PriceCalculatorResult;
}
