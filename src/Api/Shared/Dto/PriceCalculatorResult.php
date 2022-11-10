<?php
declare(strict_types=1);

namespace App\Api\Shared\Dto;

use App\Api\Shared\Domain\Interface\PriceCalculator;
use App\Domain\Entity\Product;

final class PriceCalculatorResult
{
    const CURRENCY = 'EUR';

    public function __construct(private Product $product)
    {}

    private $lines = [];

    public function addLine(CalculatorResult $calculatorResult)
    {
        if ($this->isDiscount($calculatorResult)) {
            $this->addLineDiscount($calculatorResult);
            return;
        }

        $this->doAddLine($calculatorResult);
    }

    private function addLineDiscount(CalculatorResult $calculatorResult)
    {
        $currentDiscount = $this->getAmountDiscount();
        if ($currentDiscount > $calculatorResult->amount) {
            return;
        }

        $this->doAddLine($calculatorResult);
    }

    private function doAddLine(CalculatorResult $calculatorResult)
    {
        $this->lines[$calculatorResult->key][] = $calculatorResult;
    }

    private function isDiscount(CalculatorResult $calculatorResult): bool
    {
        return PriceCalculator::CALCULATOR_DISCOUNT_TYPE == $calculatorResult->key;
    }

    public function getAmountDiscount(): ?int
    {
        return $this->totalizeKey(PriceCalculator::CALCULATOR_DISCOUNT_TYPE);
    }

    private function totalizeKey(string $key)
    {
        $result = 0;
        $lines = $this->lines[$key] ?? [];

        foreach ($lines as $line) {
            $result = $result + $line->amount;
        }

        return $result;
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
        return $this->product->getPrice() - $this->getAmountDiscount();
    }

    public function getDiscountPercentage(): ?string
    {
        $discount = $this->getDiscount();

        if (is_null($discount)) {
            return null;
        }

        return sprintf('%s%%', $discount->keyValue);
    }

    private function getDiscount()
    {
        $discountList = $this->lines[PriceCalculator::CALCULATOR_DISCOUNT_TYPE] ?? [];

        if (1 === count($discountList)) {
            return $discountList[0];
        }

        return null;
    }

    public function getCurrency()
    {
        return self::CURRENCY;
    }
}