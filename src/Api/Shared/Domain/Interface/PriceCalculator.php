<?php

declare(strict_types=1);

namespace App\Api\Shared\Domain\Interface;

use App\Api\Shared\Dto\CalculatorResult;
use App\Domain\Entity\Product;

interface PriceCalculator
{
    public const CALCULATOR_DISCOUNT_TYPE = 'discount_percentage';
    public const CALCULATOR_BASE_TYPE = 'base';

    public function supports(Product $product): bool;
    public function calculate(Product $product): CalculatorResult;
    public function getCategory(): string;
    public function getName(): string;
}
