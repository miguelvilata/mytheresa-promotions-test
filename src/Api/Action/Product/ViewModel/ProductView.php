<?php
declare(strict_types=1);

namespace App\Api\Action\Product\ViewModel;

use App\Domain\Entity\Product;

final class ProductView
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return [
            'sku' => $this->product->getSku(),
            'name' => $this->product->getName(),
            'category' => $this->product->getCategory(),
            'price' => $this->product->getPrice(),
        ];
    }
}