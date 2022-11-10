<?php
declare(strict_types=1);

namespace App\Api\Shared\Dto;

use App\Domain\Entity\Product;

final class PriceCalculatorResult
{
    const CURRENCY = 'EUR';

    public function __construct(private Product $product)
    {}

    private $lines = [];

    public function addLine(CalculatorResult $calculatorResult)
    {
        $this->lines[$calculatorResult->key][] = $calculatorResult;
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function getOriginalPrice()
    {
        return $this->product->getPrice();
    }

    public function getFinalPrice()
    {
        return $this->product->getPrice();
    }

    public function getDiscountPercentage()
    {
        return null;
    }

    public function getCurrency()
    {
        return self::CURRENCY;
    }
}