<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use Assert\Assert;

class Discount
{
    protected int $value;

    public function __construct(int $value)
    {
        Assert::that($value)->nullOr()->between(0, 100);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
