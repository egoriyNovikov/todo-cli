<?php

use EgorNovikov\TodoCli\App;
use EgorNovikov\TodoCli\Console\Commands\ArgvInput;
use EgorNovikov\TodoCli\Database\Database;

require_once __DIR__ . '/vendor/autoload.php';

$databaseConfig = require __DIR__ . '/config/database.php';

try {
$db = new Database($databaseConfig);
} catch (PDOException $e) {
  echo "\033[31mОшибка при подключении к базе данных: " . $e->getMessage() . "\033[0m\n";
  exit(1);
}

try {
  $input = new ArgvInput($argv);
  (new App($input, $db))->run();
} catch (Exception $e) {
  echo "\033[31mОшибка: " . $e->getMessage() . "\033[0m\n";
  exit(1);
}