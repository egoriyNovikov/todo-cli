<?php

use EgorNovikov\TodoCli\App;
use EgorNovikov\TodoCli\Console\Commands\ArgvInput;
use EgorNovikov\TodoCli\Database\Database;

require_once __DIR__ . '/vendor/autoload.php';

$databaseConfig = require __DIR__ . '/config/database.php';
$db = new Database($databaseConfig);

$input = new ArgvInput($argv);

(new App($input, $db))->run();