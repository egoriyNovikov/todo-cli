<?php

namespace EgorNovikov\TodoCli\Console;

use EgorNovikov\TodoCli\Console\Commands\ArgvInput;
use EgorNovikov\TodoCli\Console\Commands\Enum\CommandsEnum;
use EgorNovikov\TodoCli\Database\Database;

class Console {

  public function __construct(
    private ArgvInput $input,
    private Database $db,
  ) {}

  public function run(): void {
    $input = $this->input->fromGlobals();

    if (!$input['command']) {
      $userInput = explode(' ', readline("Введите команду: "));
      $input['command'] = $userInput[0];
      $input['arguments'] = ArgvInput::normalizeArguments(array_slice($userInput, 1) ?? null);
    }
    
    if(!CommandsEnum::tryFrom($input['command'])) {
      echo "\033[31mНеизвестная команда\033[0m\n";
    }
    $command = CommandsEnum::tryFrom($input['command'])->commandClass();
    
    $commandInstance = new $command($this->input, $this->db);
    $commandInstance->execute($input['arguments']);
    
  }
}