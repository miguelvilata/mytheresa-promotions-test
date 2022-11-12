<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

class Money
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function valueInt(): int
    {
        return $this->value;
    }

    public function currency()
    {
        return '€';
    }
}
