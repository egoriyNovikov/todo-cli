<?php

$_ENV = getenv();

$password = file_get_contents($_ENV['PASSWORD_FILE_PATH']);

return [
  'dsn' => "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
  'username' => $_ENV['DB_USER'],
  'password' => $password,
];