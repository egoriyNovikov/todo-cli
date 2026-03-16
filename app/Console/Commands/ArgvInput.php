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

  private function parseFlags(array $arguments): array {
    return array_values(array_filter($arguments, fn($arg) => str_starts_with($arg, '-') && str_starts_with($arg, '--')));
  }

  private function parseAttributes(array $arguments): array {
    return array_map(function($argument) {
      $list = explode('=', $argument);
      return [
        'key' => $list[0],
        'value' => $list[1] ?? null,
      ];
    }, array_filter($arguments, fn($arg) => str_contains($arg, '=') && !str_starts_with($arg, '--')));
  }

  private function parseTinyFlags(array $arguments): array {
    return array_map(function($argument) {
      return [
        'key' => $argument,
        'value' => true,
      ];
    }, array_filter($arguments, fn($arg) => str_starts_with($arg, '-') && !str_starts_with($arg, '--') && !str_contains($arg, '=')));
  }

  private function parseOther(array $arguments): array {
    return array_filter($arguments, fn($arg) => !str_starts_with($arg, '-') && !str_contains($arg, '='));
  }
}