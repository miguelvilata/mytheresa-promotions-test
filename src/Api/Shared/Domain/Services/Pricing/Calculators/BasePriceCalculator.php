<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing\Calculators;

use App\Domain\Entity\Product;
use App\Api\Shared\Domain\Interface\PriceCalculator;

final class BasePriceCalculator implements PriceCalculator
{
    public function supports(Product $product, array $processedLines): bool
    {
        return true;
    }

    public function calculate(Product $product)
    {
        return $product->getPrice();
    }

    public function order(): int
    {
        return 1;
    }

    public function getCategory(): string
    {
        return 'base';
    }

    public function getName(): string
    {
        return 'BasePriceCalculator';
    }
}