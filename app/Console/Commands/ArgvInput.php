<?php

namespace EgorNovikov\TodoCli\Console\Commands;

class ArgvInput 
{
  public function __construct(private array $argv) {}


  public function fromGlobals(): array {
    return [
      'filename' => $this->argv[0],
      'command' => $this->argv[1] ?? null,
      'arguments' => $this->normalizeArguments(array_slice($this->argv, 2) ?? null),
    ];
  }

  public static function normalizeArguments(?array $arguments): ?array {
    if (!$arguments) return null;
    $flags      = self::parseFlags($arguments);
    $attributes = self::parseAttributes($arguments);
    $tiny_flags = self::parseTinyFlags($arguments);
    $other      = self::parseOther($arguments);

    return [
      'flags'      => $flags,
      'attributes' => $attributes,
      'tiny_flags' => $tiny_flags,
      'other'      => $other,
    ];

  }

  private static function parseFlags(array $arguments): array {
    return array_values(array_filter($arguments, fn($arg) => str_starts_with($arg, '-') && str_starts_with($arg, '--')));
  }

  private static function parseAttributes(array $arguments): array {
    $result = [];
    $items = array_values(array_filter($arguments, fn($arg) => str_contains($arg, '=') && !str_starts_with($arg, '--')));
    foreach ($items as $argument) {
      [$key, $value] = array_pad(explode('=', $argument, 2), 2, null);
      $result[$key] = $value;
    }
    return $result;
  }

  private static function parseTinyFlags(array $arguments): array {
    $result = [];
    foreach ($arguments as $argument) {
      if (str_starts_with($argument, '-') && !str_starts_with($argument, '--') && !str_contains($argument, '=')) {
        $result[$argument] = true;
      }
    }
    return $result;
  }

  private static function parseOther(array $arguments): array {
    return array_values(array_filter($arguments, fn($arg) => !str_starts_with($arg, '-') && !str_contains($arg, '=')));
  }
}