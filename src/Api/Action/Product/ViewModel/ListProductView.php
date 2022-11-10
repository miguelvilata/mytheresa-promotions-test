<?php
declare(strict_types=1);

namespace App\Api\Action\Product\ViewModel;

final class ListProductView
{
    private iterable $productList;

    public function __construct(iterable $productList)
    {
        $this->productList = $productList;
    }

    public function render()
    {
        $result = [];

        foreach ($this->productList as $product) {
            $result[] = (new ProductView($product))->render();
        }
    }
}