<?php

namespace EgorNovikov\TodoCli\Console\Commands;

use EgorNovikov\TodoCli\Console\Commands\Enum\CommandsEnum;

class HelpCommand extends BasicCommand {

  public function help(): void {
    echo "Помощь по командам\n";
    echo "Команды:\n";
    foreach (CommandsEnum::cases() as $cmd) {
      echo "  " . $cmd->value . "\n";
    }
  }

  public function execute(?array $arguments = null): void {
    echo "Помощь по командам\n";
    echo "Команды:\n";
    foreach (CommandsEnum::cases() as $cmd) {
      echo "  " . $cmd->value . "\n";
    }
  }
}