<?php
declare(strict_types=1);

namespace App\Api\Action\Test\Handler;

use App\Api\Action\Test\Command\TestCommand;
use App\Api\Shared\Domain\Interface\CommandHandler;

class TestCommandHandler implements CommandHandler
{
    public function __invoke(TestCommand $command)
    {
        return $command->text;
    }
}
