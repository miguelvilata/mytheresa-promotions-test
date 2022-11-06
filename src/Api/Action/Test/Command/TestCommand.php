<?php
declare(strict_types=1);

namespace App\Api\Action\Test\Command;

class TestCommand
{
    public $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}
