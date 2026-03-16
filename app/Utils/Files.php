<?php

namespace EgorNovikov\TodoCli\Utils;

class Files {
  private static string $basePath = __DIR__ . '/../../';

  public static function createFile(string $path): void {
    if(!file_exists($path)) {
      file_put_contents($path, '');
    }
  }
  public static function createDirectory(string $path): void {
    if(!file_exists($path)) {
      mkdir($path, 0777, true);
    }
  }
  public static function createModel(string $model): void {
    self::createDirectory(self::$basePath . 'app/Models/');
    $path = self::$basePath . 'app/Models/' . $model . '.php';
    self::createFile($path);
  }

  public static function createMigration(string $migration): void {
    self::createDirectory(self::$basePath . 'db/migrations/');
    $path = self::$basePath . 'db/migrations/' . $migration . '.php';
    self::createFile($path);
  }

  public static function createController(string $controller): void {
    self::createDirectory(self::$basePath . 'app/Http/Controllers/');
    $path = self::$basePath . 'app/Http/Controllers/' . $controller . '.php';
    self::createFile($path);
  }
}