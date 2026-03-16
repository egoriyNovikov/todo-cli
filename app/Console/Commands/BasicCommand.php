<?php

namespace EgorNovikov\TodoCli\Console\Commands;

use EgorNovikov\TodoCli\Console\Commands\ArgvInput;
use EgorNovikov\TodoCli\Database\Database;

abstract class BasicCommand 
{

  public function __construct(
    protected ArgvInput $input,
    protected Database $db,
  ) {}

  abstract public function execute(?array $arguments = null): void;
  abstract public function help(): void;

}