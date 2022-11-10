<?php
declare(strict_types=1);

namespace App\Api\Action\Product\Command;

class ListProductCommand
{
    public $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}
