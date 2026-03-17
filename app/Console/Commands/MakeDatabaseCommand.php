<?php

namespace EgorNovikov\TodoCli\Console\Commands;

use EgorNovikov\TodoCli\Utils\Files;

class MakeDatabaseCommand extends BasicCommand {

  private array $map = [
    '--model' => 'model',
    '-mod'    => 'model',
    '--migration' => 'migration',
    '-mig' => 'migration',
    '--controller' => 'controller',
    '-con' => 'controller',
    '--all' => 'all',
    '-all' => 'all',
  ];

  public function help(): void {
    echo "Создание модели и миграции\n";
    echo "Использование: make <model> [--migration] [--controller]\n";
    echo "Флаги:\n";
    echo "  --migration: Создание миграции\n";
    echo "  --controller: Создание контроллера\n";
  }

  public function execute(?array $arguments = null): void {
    if(!$arguments) {
      $argumenst = readline("Введите aргументы: ");
      if(!$argumenst) {
        echo "\033[31mНекорректные аргументы\033[0m\n";
        return;
      }
      $arguments = explode(' ', $argumenst);
      $arguments = ArgvInput::normalizeArguments($arguments);
    }

    $files = new Files();

    $flags      = $arguments['flags'] ?? [];
    $tinyFlags  = $arguments['tiny_flags'] ?? [];
    $attributes = $arguments['attributes'] ?? [];
    $other      = $arguments['other'] ?? [];

    // Что создавать
    $all        = in_array('--all', $flags, true) || isset($tinyFlags['-all']);
    $createModel     = in_array('--model', $flags, true)     || isset($tinyFlags['-mod']);
    $createMigration = in_array('--migration', $flags, true) || isset($tinyFlags['-mig']);
    $createController= in_array('--controller', $flags, true)|| isset($tinyFlags['-con']);

    // Имя: сначала позиционный аргумент, потом атрибут --name / -name
    $name = $other[0] ?? ($attributes['--name'] ?? ($attributes['-name'] ?? null));

    if ($name === null) {
      echo "\033[31mНе указано имя модели\033[0m\n";
      return;
    }

    if (!$all && !$createModel && !$createMigration && !$createController) {
      echo "\033[31mНе указано, что создавать (флаги --model/--migration/--controller/--all)\033[0m\n";
      return;
    }

    // Выполнение действий
    if ($all || $createModel) {
      $files->createModel($name);
    }
    if ($all || $createMigration) {
      $files->createMigration($name);
    }
    if ($all || $createController) {
      $files->createController($name);
    }
    echo "\033[32mФайлы созданы\033[0m\n";
  }
}