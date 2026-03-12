<?php

namespace EgorNovikov\TodoCli\Console;

class Console {

  public function __construct(private array $argv) {}

  public function run() {
    dd($this->argv);
  }
}