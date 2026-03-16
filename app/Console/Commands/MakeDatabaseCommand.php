<?php

namespace EgorNovikov\TodoCli\Console\Commands;

use EgorNovikov\TodoCli\Utils\Files;

class MakeDatabaseCommand extends BasicCommand {

  public function help(): void {
    echo "Создание модели и миграции\n";
    echo "Использование: make <model> [--migration] [--controller]\n";
    echo "Флаги:\n";
    echo "  --migration: Создание миграции\n";
    echo "  --controller: Создание контроллера\n";
  }

  public function execute(?array $arguments = null): void {
    dd($arguments);
    $files = new Files();
    $model = $arguments['attributes'];
    if(!$arguments) {
      $argumenst = readline("Введите aргументы: ");
      if(!$argumenst) {
        echo "\033[31mНекорректные аргументы\033[0m\n";
        return;
      }
      $arguments = explode(' ', $argumenst);
      $arguments = ArgvInput::normalizeArguments($arguments);
    }
    if(in_array('--model', $arguments['flags']) || in_array('--all', $arguments['flags']) || in_array('-m', $arguments['tiny_flags'])) {
      $files->createModel($model);
      echo "\033[32mМодель $model создана\033[0m\n";
      return;
    }
    if(in_array('--migration', $arguments['flags']) || in_array('--all', $arguments['flags']) || in_array('-m', $arguments['tiny_flags'])) {
        $migration = $model . '_migration';
        $files->createMigration($migration);
        echo "\033[32mМиграция $migration создана\033[0m\n";
    }
    if(in_array('--controller', $arguments['flags']) || in_array('--all', $arguments['flags']) || in_array('-c', $arguments['tiny_flags'])) {
        $controller = $model . '_controller';
        $files->createController($controller);
        echo "\033[32mКонтроллер $controller создан\033[0m\n";
    }
    echo "\033[31mНекорректные аргументы\033[0m\n";
  }
}