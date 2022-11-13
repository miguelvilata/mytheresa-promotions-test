<?php

declare(strict_types=1);

namespace App\Api\Shared\Dto;

use App\Api\Shared\Domain\Interface\PriceCalculatorCommandInterface;
use App\Api\Shared\Domain\Interface\PriceCalculatorInterface;
use App\Domain\Entity\Product;
use App\Api\Shared\Domain\Exception\InvalidPercentageDiscountException;
use App\Domain\ValueObject\Discount;

class PriceCalculatorResult
{
    private const CURRENCY = 'EUR';

    public function __construct(private Product $product)
    {
    }

    private array $lines = [];

    public function addLine(CalculatorResult $calculatorResult): self
    {
        if ($this->isDiscount($calculatorResult)) {
            $this->addLineDiscount($calculatorResult);
            return $this;
        }

        $this->doAddLine($calculatorResult);

        return $this;
    }

    private function addLineDiscount(CalculatorResult $calculatorResult): void
    {
        $currentDiscount = $this->getAmountDiscount();
        if ($currentDiscount > $calculatorResult->amount) {
            return;
        }

        $this->doAddLine($calculatorResult);
    }

    private function doAddLine(CalculatorResult $calculatorResult): void
    {
        $this->lines[$calculatorResult->key][] = $calculatorResult;
    }

    private function isDiscount(CalculatorResult $calculatorResult): bool
    {
        return PriceCalculatorCommandInterface::CALCULATOR_DISCOUNT_TYPE == $calculatorResult->key;
    }

    public function getAmountDiscount(): ?int
    {
        return $this->totalizeKey(PriceCalculatorCommandInterface::CALCULATOR_DISCOUNT_TYPE);
    }

    private function totalizeKey(string $key): ?int
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

    public function getDiscountPercentage(): null|string|InvalidPercentageDiscountException
    {
        $discount = $this->getDiscount();
        if (is_null($discount)) {
            return null;
        }

        try {
            $discountPercentage = (new Discount($discount->keyValue))->value();
        } catch (\Exception $exception) {
            throw new InvalidPercentageDiscountException($exception->getMessage());
        }

        return sprintf('%s%%', $discount->keyValue);
    }

    private function getDiscount()
    {
        $discountList = $this->lines[PriceCalculatorCommandInterface::CALCULATOR_DISCOUNT_TYPE] ?? [];

        if (1 === count($discountList)) {
            return $discountList[0];
        }

        return null;
    }

    public function getCurrency()
    {
        return self::CURRENCY;
    }

    public function getCategory(): string
    {
        return $this->product->getCategory();
    }
}
