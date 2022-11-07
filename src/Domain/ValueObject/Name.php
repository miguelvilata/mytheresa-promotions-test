<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Assert\Assert;

class Name
{
    protected string $value;

    public function __construct(string $value)
    {
        Assert::that($value)->betweenLength(1, 50);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
