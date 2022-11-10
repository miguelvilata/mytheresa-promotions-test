<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Services\Pricing\Calculators;

use App\Api\Shared\Domain\Interface\PriceCalculator;
use App\Domain\Entity\Product;

class DiscountBySkuCalculator implements PriceCalculator
{
    const SKUS = ['000003'];
    const DEFAULT_DISCOUNT = 15;

    public function supports(Product $product, array $processedLines): bool
    {
        $currentDiscountApplied = $processedLines[$this->getCategory()] ?? null;
        if (!is_null($currentDiscountApplied)) {
            $asf = '';
        }

        return true;
    }

    public function calculate(Product $product): int
    {
        $productPrice = $product->getPrice();
        $discount = $productPrice * (self::DEFAULT_DISCOUNT / 100);
        $t = $discount * -1;

        return (int)$t;
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