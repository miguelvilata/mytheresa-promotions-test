<?php
declare(strict_types=1);

namespace App\Api\Action\Product\Command;

class ListProductCommand
{
    const CATEGORY_FILTER = 'category';
    const PRICE_PRICE_LT_FILTER = 'price_lt';

    public array $filters = [];

    public function __construct($payload)
    {
        $this->filters[self::CATEGORY_FILTER] = $payload[self::CATEGORY_FILTER] ?? null;
        $this->filters[self::PRICE_PRICE_LT_FILTER] = $payload[self::PRICE_PRICE_LT_FILTER] ?? null;
    }

    public function getFilters()
    {
        return array_filter($this->filters);
    }
}
