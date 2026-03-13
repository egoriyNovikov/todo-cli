<?php

namespace EgorNovikov\TodoCli;

use EgorNovikov\TodoCli\Console\Commands\ArgvInput;
use EgorNovikov\TodoCli\Console\Console;
use EgorNovikov\TodoCli\Database\Database;

class App {

  public function __construct(
    private ArgvInput $input,
    private Database $db,
  ) {}

  public function run(): void {
    $console = new Console($this->input, $this->db);
    $console->run();
  }
}