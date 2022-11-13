<?php

declare(strict_types=1);

namespace ApiBundle\ValueObject;

use Assert\Assert;

class Percentage
{
    protected int $value;

    public function __construct(int $value)
    {
        Assert::that($value)->betweenLength(1, 100);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function withFormat()
    {
        return sprintf('%s%%', $this->value);
    }
}
