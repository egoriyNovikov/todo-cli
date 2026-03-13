<?php

namespace EgorNovikov\TodoCli\Console\Commands\Enum;

enum CommandsEnum: string {
  case HELP = 'help';
  case LIST = 'list';
  case ADD = 'add';
  case COMPLETE = 'complete';
  case DELETE = 'delete';
}