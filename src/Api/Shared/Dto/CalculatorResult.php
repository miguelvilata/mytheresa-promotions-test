<?php

declare(strict_types=1);

namespace App\Api\Shared\Dto;

final class CalculatorResult
{
    public function __construct(public string $name, public int $amount, public string $key, public ?int $keyValue = null)
    {
    }
}
