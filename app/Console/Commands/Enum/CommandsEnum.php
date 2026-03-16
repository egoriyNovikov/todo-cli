<?php

namespace EgorNovikov\TodoCli\Console\Commands\Enum;

use EgorNovikov\TodoCli\Console\Commands\HelpCommand;
use EgorNovikov\TodoCli\Console\Commands\MakeDatabaseCommand;

enum CommandsEnum: string {
  case HELP = 'help';
  case MAKE_DATABASE = 'make';
  case LIST = 'list';
  case ADD = 'add';
  case COMPLETE = 'complete';
  case DELETE = 'delete';

  /** Класс команды для этого case */
  public function commandClass(): string {
    return match ($this) {
      self::HELP => HelpCommand::class,
      self::MAKE_DATABASE => MakeDatabaseCommand::class,
    };
  }
}