<?php
declare(strict_types=1);

namespace App\Api\Shared\Domain\Interface;

use App\Domain\Entity\Product;

interface PriceCalculator
{
    public function supports(Product $product, array $processedLines): bool;
    public function calculate(Product $product);
    public function order(): int;
    public function getCategory(): string;
    public function getName(): string;
}