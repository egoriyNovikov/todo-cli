<?php

namespace EgorNovikov\TodoCli\Console;

use EgorNovikov\TodoCli\Console\Commands\ArgvInput;
use EgorNovikov\TodoCli\Database\Database;
use EgorNovikov\TodoCli\Console\Commands\Enum\CommandsEnum;

class Console {

  public function __construct(
    private ArgvInput $input,
    private Database $db,
  ) {}

  public function run() {
    $input = $this->input->fromGlobals();
    if (CommandsEnum::tryFrom($input['command'])) {
      $this->$input['command']($input['arguments']);
    } else {
      $userInput = explode(' ', readline("Введите команду: "));
      $input['command'] = $userInput[0];
      $input['arguments'] = ArgvInput::normalizeArguments(array_slice($userInput, 1) ?? null);
      dd($input);
    }
  }
}